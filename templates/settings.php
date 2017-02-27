      <!--
       Licensed under Expat License

       See LICENSE in the root of the source tree

       Copyright (c) Ferenc Szekely <ferenc.szekely@urho.eu>
      -->

      <div class="wrap settings">
        <h2><?php _e('Settings', L10N_DOMAIN); ?></h2>

        <form method="post" action="">
          <h3><?php _e('everynet API URLs', L10N_DOMAIN); ?></h3>

          <div class="urls">
            <div class="odd">
              <span class="col1"><?php _e('everynet Core URL', L10N_DOMAIN); ?></span>
              <span class="col2">
                <input type="text" id="plugin_settings_everynet_core_url" name="plugin_settings[everynet_core_url]" size="65" value="<?php
                    echo (isset($settings['everynet_core_url']) ? htmlspecialchars ($settings['everynet_core_url']) : '');
                ?>" />
              </span>
            </div>
            <div class="odd">
              <span class="col1"><?php _e('everynet REST URL', L10N_DOMAIN); ?></span>
              <span class="col2">
                <input type="text" id="plugin_settings_everynet_rest_url" name="plugin_settings[everynet_rest_url]" size="65" value="<?php
                    echo (isset($settings['everynet_rest_url']) ? htmlspecialchars ($settings['everynet_rest_url']) : '');
                ?>" />
              </span>
            </div>
          </div>

          <h3><?php _e('everynet API keys', L10N_DOMAIN); ?></h3>
          <div class="keys">
            <div class="header odd">
              <span class="col1"><?php _e('everynet API key', L10N_DOMAIN); ?></span>
              <span class="col2"><?php _e('everynet API key comment', L10N_DOMAIN); ?></span>
            </div>
            <?php
              $i = 0;
              foreach ($settings['everynet_api_keys'] as $index => $key) {
                $last = ($i == count($settings['everynet_api_keys']) - 1);
            ?>
            <div class="odd key" data-index="<?php echo $i;?>">
              <span class="col1">
                <input type="text" name="plugin_settings[everynet_api_keys][<?php echo $i;?>][key]" size="70"
                value="<?php echo $key['key'];?>" />
              </span>
              <span class="col2">
                <input type="text" name="plugin_settings[everynet_api_keys][<?php echo $i;?>][comment]" size="20"
                value="<?php echo $key['comment'];?>" />
              </span>
              <?php
                if ($last) {
              ?>
              <span class="control button-primary add">+</span>
              <?php
                }
              ?>
              <span class="control button-primary delete">-</span>
            </div>
            <?php
                $i++;
              }
            ?>
          </div>

          <?php
            if (isset($settings['feedback']))
            {
          ?>
          <div class="feedback <?php echo $settings['feedback']['status']; ?>">
            <?php echo $settings['feedback']['message']; ?>
          </div>
          <?php
            }
          ?>

          <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes', L10N_DOMAIN) ?>" />
          </p>
        </form>
      </div>
