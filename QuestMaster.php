<?php
/*
Plugin Name: QuestMaster
Description: Partez a la chasse d'un trésor sur Wordpress.
Version: 1.0.0
Author: Grégory Saimoen
*/
// Sécurité : empêcher l'accès direct au fichier
defined('ABSPATH') or die('Accès interdit');
// Inclure d'autres fichiers de votre plugin
require_once plugin_dir_path(__FILE__) . 'includes/controllers/controller.php';
// Actions WordPress pour charger des scripts et styles
function questmaster_enqueue_scripts() {
    // Si l'utilisateur est un administrateur, chargez la vue de l'extension
    if (current_user_can('administrator')) {
        // Chargez les fichiers JavaScript et CSS de l'extension
        wp_enqueue_script('mon-plugin-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', array(), '1.0', true);
        wp_enqueue_style('mon-plugin-style', plugin_dir_url(__FILE__) . 'assets/css/style.css', array(), '1.0');
    }
}
add_action('wp_enqueue_scripts', 'questmaster_enqueue_scripts');

function mon_plugin_menu() {
    // Ajoutez des éléments de menu ou des pages d'administration ici, si nécessaire
}
add_action('admin_menu', 'mon_plugin_menu');

// Actions WordPress pour traiter les fonctions personnalisées, si nécessaire
function mon_plugin_custom_function() {
    // Ajoutez vos fonctions personnalisées ici, si nécessaire
}

// Activation et désactivation du plugin
function mon_plugin_activate() {
    // Effectuez des actions lors de l'activation du plugin, si nécessaire
}

function mon_plugin_deactivate() {
    // Effectuez des actions lors de la désactivation du plugin, si nécessaire
}

function game_display() {
    ob_start();
    ?>
    <div style="width: 100%" id="game-container">
        <?php
        // Inclure le contenu de votre fichier index.php
        include(plugin_dir_path(__FILE__) . '\includes\index.php');
        ?>
    </div>
    <?php
    return ob_get_clean();
}
function game_display_shortcode() {
    return game_display();
}
add_shortcode('game', 'game_display_shortcode');


register_activation_hook(__FILE__, 'mon_plugin_activate');
register_deactivation_hook(__FILE__, 'mon_plugin_deactivate');
