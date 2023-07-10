<?php
/**
 * Chatbot ChatGPT for WordPress - Settings - Premium Page
 *
 * This file contains the code for the Chatbot ChatGPT settings page.
 * It allows users to configure the API key and other parameters
 * required to access the ChatGPT API from their own account.
 *
 * @package chatbot-chatgpt
 */

// Avatar Icon - Ver 1.4.3
function chatbot_chatgpt_avatar_callback($args) {
    // Get the avatar option. If it's not set or is NULL, default to an empty string.
    $avatar = "";
    $avatar = esc_attr(get_option('chatgpt_avatar_icon_setting', 'icon-001.png'));
    ?>
    <input type="text" id="chatgpt_avatar_icon" name="chatgpt_avatar_icon" value="<?php echo esc_attr( $avatar ); ?>" class="regular-text">
    <?php
}

// Avatar Icon settings section callback - Ver 1.4.3
function chatbot_chatgpt_avatar_section_callback($args) {
    // Get the avatar option. If it's not set or is NULL, default to an empty string.
    $avatar = "";
    $avatar = esc_attr(get_option('chatgpt_avatar_icon_setting', 'icon-001.png'));
    ?>
    <p>Select your icon by clicking on an image to select it.  Don't forget to click 'Save Settings'.</p>
    <table>
        <?php
            $iconCount = 7;  // Update this number as you add more icons
            $cols = 5;
            $rows = 4;
            $iconIndex = 1;

            $selectedIcon = esc_attr(get_option('chatgpt_avatar_icon_setting', 'icon-001.png'));
            
            for($i = 0; $i < $rows; $i++) {
                echo '<tr>';
                for($j = 0; $j < $cols; $j++) {
                    if ($iconIndex <= $iconCount) {
                        $iconName = sprintf("icon-%03d.png", $iconIndex);
                        $selected = ""; 
                        $selected = ($iconName === $selectedIcon) ? 'style="width:160px;height:160px;cursor:pointer;border:2px solid red;"' : '';
                        echo '<td  style="padding: 15px;">';
                        echo '<img src="' . plugins_url('../assets/icons/'.$iconName, __FILE__) . '" id="'.$iconName.'" onclick="selectIcon(this.id)" " '.$selected.'/>';
                        echo '</td>';
                        $iconIndex++;
                    }
                }
                echo '</tr>';
            }
        ?>
    </table>
    <script>
        function selectIcon(id) {
            // Clear border from previous selected icon
            var previousIcon = document.getElementById(document.getElementById('chatgpt_avatar_icon').value);
            if(previousIcon) previousIcon.style.border = "";

            // Set border for new selected icon
            var selectedIcon = document.getElementById(id);
            selectedIcon.style.border = "2px solid red";

            // Set selected icon value in hidden input
            document.getElementById('chatgpt_avatar_icon').value = id;
        }
        
        window.onload = function() {
            // If no icon has been selected, select the first one by default
            var iconFromStorage = localStorage.getItem('chatgpt_avatar_icon_setting');
            if (iconFromStorage) {
                selectIcon(iconFromStorage);
            } else if (document.getElementById('chatgpt_avatar_icon').value == '') {
                selectIcon('icon-001.png');
            }
        }

        function selectIcon(id) {
            // Clear border from previous selected icon
            var previousIcon = document.getElementById(document.getElementById('chatgpt_avatar_icon').value);
            if(previousIcon) previousIcon.style.border = "";

            // Set border for new selected icon
            var selectedIcon = document.getElementById(id);
            selectedIcon.style.border = "2px solid red";

            // Set selected icon value in hidden input
            document.getElementById('chatgpt_avatar_icon').value = id;

            // Save selected icon in local storage
            localStorage.setItem('chatgpt_avatar_icon_setting', id);
        }

    </script>
    <?php
}

