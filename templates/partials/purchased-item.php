<tr>
  <?php /* ?><td><a href="#id<?php the_field('purchase_id') ?>" class="popup"><?php the_title() ?></a></td> */?>
  <td><?php the_title() ?></td>
  <td align="right">
    <!-- <span class="status on" title="Ad Written"><i class="far fa-pencil"></i></span>
    <span class="status on" title="Ad Approved"><i class="far fa-check-circle"></i></span> -->
      

    <div id="id<?php the_field('purchase_id') ?>" class="mfp-hide popupwindow" >
      <div id="manageads">
        <h3>Your ads: <?php the_title() ?></h3>
        <hr>
        <div>
          <h4 class="label">Jan 14</h4>
          <p>
            <label for="descriptor">Descriptor</label><br>
            <input type="text" name="descriptor" value="powered by" placeholder="powered by" id="descriptor">
          </p>
      
          <p>
            <label>Ad Copy</label><br>
            <textarea style="width:100%"></textarea>
          </p>
      
          <p>
            <label>Link</label><br>
            <input type="text" name="link" value="" placeholder="http://www.morningchalkup.com" id="link">
          </p>
      
          <p>
            <label>Hyperlinked Text</label><br>
            <input type="text" name="link_text" value="" placeholder="learn more" id="link_text">
          </p>
        
          <hr>
        </div>
        
        <div>
          <h4 class="label">Jan 15</h4>
          <p>
            <label for="descriptor">Descriptor</label><br>
            <input type="text" name="descriptor" value="powered by" placeholder="powered by" id="descriptor">
          </p>
      
          <p>
            <label>Ad Copy</label><br>
            <textarea style="width:100%"></textarea>
          </p>
      
          <p>
            <label>Link</label><br>
            <input type="text" name="link" value="" placeholder="http://www.morningchalkup.com" id="link">
          </p>
      
          <p>
            <label>Hyperlinked Text</label><br>
            <input type="text" name="link_text" value="" placeholder="learn more" id="link_text">
          </p>
        
          <hr>
        </div>
        
      </div>
    </div>
    
  </td>
</tr>
