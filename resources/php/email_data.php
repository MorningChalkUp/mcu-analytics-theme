<?php
  
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  require_once '/vars.php';
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

      foreach ($clicks as $click) {
        foreach ($ad_domains as $ad_domain) {
          $url = parse_url($click->URL);
          if ($url['host'] == $ad_domain) {
            ++$ad_click;
            if (isset($links[$click->URL])) {
              ++$links[$click->URL];
            } else {
              $links[$click->URL] = 1;
            }
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
        'recipiants' => $result->response->Recipients,
        'opens' => $result->response->UniqueOpened,
        'clicks_unique' => $result->response->Clicks,
        'clicks_total' => count($clicks),
        'ad_clicks' => $ad_click,
        'ad_links' => $links,
        'title' => $title,
        'web_view' => $result->response->WebVersionURL,
      );

      return $data;
    }
  }
?>