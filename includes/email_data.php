<?php 
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    require_once ABSPATH.'/vars.php';
    require_once 'cm/csrest_campaigns.php';
    require_once 'cm/csrest_clients.php';
    
    function mcu_get_email_data($id, $ad_domains) {
    
      $auth = array('api_key' => CM_API_KEY);
      $wrap = new CS_REST_Campaigns($id, $auth);
    
      $result = $wrap->get_summary();
    
      if ($result != false) {
        $page = 1;
        $size = 1000;
        $break = false;
        $clicks = [];
        do {
          $click_json = $wrap->get_clicks('2000-01-01', $page, $size);
          $clicks = array_merge($clicks, $click_json->response->Results);
          if (count($click_json->response->Results) < $size) {
            $break = true;
          }
          ++$page;
        } while (!$break);
    
        $ad_click = 0;
        
        $ad_links = array();
        foreach ($clicks as $click) {
          foreach ($ad_domains as $ad_domain) {
            // see if click link is on ad domain
            if (strpos($click->URL, $ad_domain['url']) !== false) {
              $ad_click ++;
              // check to see if link is in $ad_link
              if(!isset($ad_links[$click->URL])) {
                $ad_links[$click->URL] = 1;
              } else {
                $ad_links[$click->URL]++;
              }
              // if it is not, then add it
              // increment click count by one
            }
          }
        }
    
        $wrap2 = new CS_REST_Clients(
            CM_CLIENT_ID, 
            $auth);
    
        $campaign_list = $wrap2->get_campaigns();
    
        foreach ($campaign_list->response as $campaign) {
          if ($campaign->CampaignID == $id) {
            $title = $campaign->Name;
            break;
          }
        }
    
        $data = array(
          'recipients' => $result->response->Recipients,
          'opens' => $result->response->UniqueOpened,
          'clicks_unique' => $result->response->Clicks,
          'clicks_total' => count($clicks),
          'ad_clicks' => $ad_click,
          'ad_links' => $ad_links,
          'title' => $title,
          'web_view' => $result->response->WebVersionURL,
        );
    
        return $data;
      }
    }
?>
