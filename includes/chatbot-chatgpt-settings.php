<?php
/**
 * Chatbot ChatGPT for WordPress - Settings Page
 *
 * This file contains the code for the Chatbot ChatGPT settings page.
 * It allows users to configure the API key and other parameters
 * required to access the ChatGPT API from their own account.
 *
 * @package chatbot-chatgpt
 */

function chatbot_chatgpt_settings_page() {
    add_options_page('Chatbot ChatGPT Settings', 'Chatbot ChatGPT', 'manage_options', 'chatbot-chatgpt', 'chatbot_chatgpt_settings_page_html');
}
add_action('admin_menu', 'chatbot_chatgpt_settings_page');

// Settings page HTML - Ver 1.3.0
function chatbot_chatgpt_settings_page_html() {
    if (!current_user_can('manage_options')) {
        return;
    }

    $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'api_model';

    if (isset($_GET['settings-updated'])) {
        add_settings_error('chatbot_chatgpt_messages', 'chatbot_chatgpt_message', 'Settings Saved', 'updated');
    }

    // REMOVED Ver 1.3.0
    // settings_errors('chatbot_chatgpt_messages');
    
    ?>
    <div class="wrap">
        <h1><span class="dashicons dashicons-format-chat"></span> <?php echo esc_html(get_admin_page_title()); ?></h1>

        <!-- Message Box - Ver 1.3.0 -->
        <div id="message-box-container"></div>

        <!-- Message Box - Ver 1.3.0 -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const chatgptSettingsForm = document.getElementById('chatgpt-settings-form');
                // Read the start status - Ver 1.4.1
                const chatgptStartStatusInput = document.getElementById('chatGPTChatBotStatus');
                const reminderCount = localStorage.getItem('reminderCount') || 0;

                if (reminderCount < 5) {
                    const messageBox = document.createElement('div');
                    messageBox.id = 'rateReviewMessageBox';
                    messageBox.innerHTML = `
                    <div id="rateReviewMessageBox" style="background-color: white; border: 1px solid black; padding: 10px; position: relative;">
                        <div class="message-content" style="display: flex; justify-content: space-between; align-items: center;">
                            <span><b>Loving the chatbot experience on our site?</b> Your feedback makes a big difference! Please click here to <a href="https://wordpress.org/support/plugin/chatbot-chatgpt/reviews/" target="_blank">rate and review</a> our plugin. It only takes a minute, but it helps us immensely. <b>Thank you for your support!</b></span>
                            <button id="closeMessageBox" class="dashicons dashicons-dismiss" style="background: none; border: none; cursor: pointer; outline: none; padding: 0; margin-left: 10px;"></button>
                            
                        </div>
                    </div>
                    `;

                    document.querySelector('#message-box-container').insertAdjacentElement('beforeend', messageBox);

                    document.getElementById('closeMessageBox').addEventListener('click', function() {
                        messageBox.style.display = 'none';
                        localStorage.setItem('reminderCount', parseInt(reminderCount, 10) + 1);
                    });
                }
            });
        </script>
    
    <script>
    jQuery(document).ready(function($) {
        var chatgptSettingsForm = document.getElementById('chatgpt-settings-form');

        if (chatgptSettingsForm) {

            chatgptSettingsForm.addEventListener('submit', function() {

                // Get the input elements by their ids
                const chatgptNameInput = document.getElementById('chatgpt_bot_name');
                const chatgptInitialGreetingInput = document.getElementById('chatgpt_initial_greeting');
                const chatgptSubsequentGreetingInput = document.getElementById('chatgpt_subsequent_greeting');
                const chatgptStartStatusInput = document.getElementById('chatGPTChatBotStatus');
                const chatgptDisclaimerSettingInput = document.getElementById('chatgpt_disclaimer_setting');
                // New options for max tokens and width - Ver 1.4.2
                const chatgptMaxTokensSettingInput = document.getElementById('chatgpt_max_tokens_setting');
                const chatgptWidthSettingInput = document.getElementById('chatgpt_width_setting');

                // Update the local storage with the input values, if inputs exist
                if(chatgptNameInput) localStorage.setItem('chatgpt_bot_name', chatgptNameInput.value);
                if(chatgptInitialGreetingInput) localStorage.setItem('chatgpt_initial_greeting', chatgptInitialGreetingInput.value);
                if(chatgptSubsequentGreetingInput) localStorage.setItem('chatgpt_subsequent_greeting', chatgptSubsequentGreetingInput.value);
                if(chatgptStartStatusInput) localStorage.setItem('chatGPTChatBotStatus', chatgptStartStatusInput.value);
                if(chatgptDisclaimerSettingInput) localStorage.setItem('chatgpt_disclaimer_setting', chatgptDisclaimerSettingInput.value);
                if(chatgptMaxTokensSettingInput) localStorage.setItem('chatgpt_max_tokens_setting', chatgptMaxTokensSettingInput.value);
                if(chatgptWidthSettingInput) localStorage.setItem('chatgpt_width_setting', chatgptWidthSettingInput.value);
            });
        }
    });
</script>


        <h2 class="nav-tab-wrapper">
            <a href="?page=chatbot-chatgpt&tab=api_model" class="nav-tab <?php echo $active_tab == 'api_model' ? 'nav-tab-active' : ''; ?>">API/Model</a>
            <a href="?page=chatbot-chatgpt&tab=settings" class="nav-tab <?php echo $active_tab == 'settings' ? 'nav-tab-active' : ''; ?>">Settings</a>
            <!-- Coming Soon in Ver 2.0.0 -->
            <!-- <a href="?page=chatbot-chatgpt&tab=premium" class="nav-tab <?php echo $active_tab == 'premium' ? 'nav-tab-active' : ''; ?>">Premium</a> -->
            <a href="?page=chatbot-chatgpt&tab=support" class="nav-tab <?php echo $active_tab == 'support' ? 'nav-tab-active' : ''; ?>">Support</a>
        </h2>

        <!-- Updated id - Ver 1.4.1 -->
        <form id="chatgpt-settings-form" action="options.php" method="post">
            <?php
            if ($active_tab == 'settings') {
                settings_fields('chatbot_chatgpt_settings');
                do_settings_sections('chatbot_chatgpt_settings');
            } elseif ($active_tab == 'api_model') {
                settings_fields('chatbot_chatgpt_api_model');
                do_settings_sections('chatbot_chatgpt_api_model');
            // Coming Soon in Ver 2.0.0
            // } elseif ($active_tab == 'premium') {
            //     settings_fields('chatbot_chatgpt_premium');
            //     do_settings_sections('chatbot_chatgpt_premium');
            } elseif ($active_tab == 'support') {
                settings_fields('chatbot_chatgpt_support');
                do_settings_sections('chatbot_chatgpt_support');
            }
            submit_button('Save Settings');
            ?>
        </form>
    </div>
    <!-- Added closing tags for body and html - Ver 1.4.1 -->
    </body>
    </html>
    <?php
}


// Register settings
function chatbot_chatgpt_settings_init() {

    // API/Model settings tab - Ver 1.3.0
    register_setting('chatbot_chatgpt_api_model', 'chatgpt_api_key');
    register_setting('chatbot_chatgpt_api_model', 'chatgpt_model_choice');
    // Max Tokens setting options - Ver 1.4.2
    register_setting('chatbot_chatgpt_api_model', 'chatgpt_max_tokens_setting');

    add_settings_section(
        'chatbot_chatgpt_api_model_section',
        'API/Model Settings',
        'chatbot_chatgpt_api_model_section_callback',
        'chatbot_chatgpt_api_model'
    );

    add_settings_field(
        'chatgpt_api_key',
        'ChatGPT API Key',
        'chatbot_chatgpt_api_key_callback',
        'chatbot_chatgpt_api_model',
        'chatbot_chatgpt_api_model_section'
    );

    add_settings_field(
        'chatgpt_model_choice',
        'ChatGPT Model Choice',
        'chatbot_chatgpt_model_choice_callback',
        'chatbot_chatgpt_api_model',
        'chatbot_chatgpt_api_model_section'
    );
    
    // Setting to adjust in small increments the number of Max Tokens - Ver 1.4.2
    add_settings_field(
        'chatgpt_max_tokens_setting',
        'Maximum Tokens Setting',
        'chatgpt_max_tokens_setting_callback',
        'chatbot_chatgpt_api_model',
        'chatbot_chatgpt_api_model_section'
    );


    // Settings settings tab - Ver 1.3.0
    register_setting('chatbot_chatgpt_settings', 'chatgpt_bot_name');
    register_setting('chatbot_chatgpt_settings', 'chatGPTChatBotStatus');
    register_setting('chatbot_chatgpt_settings', 'chatgpt_initial_greeting');
    register_setting('chatbot_chatgpt_settings', 'chatgpt_subsequent_greeting');
    // Option to remove the OpenAI disclaimer - Ver 1.4.1
    register_setting('chatbot_chatgpt_settings', 'chatgpt_disclaimer_setting');
    // Option to select narrow or wide chatboat - Ver 1.4.2
    register_setting('chatbot_chatgpt_settings', 'chatgpt_width_setting');

    add_settings_section(
        'chatbot_chatgpt_settings_section',
        'Settings',
        'chatbot_chatgpt_settings_section_callback',
        'chatbot_chatgpt_settings'
    );

    add_settings_field(
        'chatgpt_bot_name',
        'Bot Name',
        'chatbot_chatgpt_bot_name_callback',
        'chatbot_chatgpt_settings',
        'chatbot_chatgpt_settings_section'
    );

    add_settings_field(
        'chatGPTChatBotStatus',
        'Start Status',
        'chatbot_chatGPTChatBotStatus_callback',
        'chatbot_chatgpt_settings',
        'chatbot_chatgpt_settings_section'
    );

    add_settings_field(
        'chatgpt_initial_greeting',
        'Initial Greeting',
        'chatbot_chatgpt_initial_greeting_callback',
        'chatbot_chatgpt_settings',
        'chatbot_chatgpt_settings_section'
    );

    add_settings_field(
        'chatgpt_subsequent_greeting',
        'Subsequent Greeting',
        'chatbot_chatgpt_subsequent_greeting_callback',
        'chatbot_chatgpt_settings',
        'chatbot_chatgpt_settings_section'
    );

    // Option to remove the OpenAI disclaimer - Ver 1.4.1
    add_settings_field(
        'chatgpt_disclaimer_setting',
        'Include "As an AI language model" disclaimer',
        'chatgpt_disclaimer_setting_callback',
        'chatbot_chatgpt_settings',
        'chatbot_chatgpt_settings_section'
    );

    // Option to change the width of the bot from narrow to wide - Ver 1.4.2
    add_settings_field(
        'chatgpt_width_setting',
        'Chatbot Width Setting',
        'chatgpt_width_setting_callback',
        'chatbot_chatgpt_settings',
        'chatbot_chatgpt_settings_section'
    );

    // Premium settings tab - Ver 1.3.0
    register_setting('chatbot_chatgpt_premium', 'chatgpt_premium_key');

    add_settings_section(
        'chatbot_chatgpt_premium_section',
        'Premium Settings',
        'chatbot_chatgpt_premium_section_callback',
        'chatbot_chatgpt_premium'
    );

    add_settings_field(
        'chatgpt_premium_key',
        'Premium Options',
        'chatbot_chatgpt_premium_key_callback',
        'chatbot_chatgpt_premium',
        'chatbot_chatgpt_premium_section'
    );

    // Support settings tab - Ver 1.3.0
    register_setting('chatbot_chatgpt_support', 'chatgpt_support_key');

    add_settings_section(
        'chatbot_chatgpt_support_section',
        'Support',
        'chatbot_chatgpt_support_section_callback',
        'chatbot_chatgpt_support'
    );
        
}

add_action('admin_init', 'chatbot_chatgpt_settings_init');
