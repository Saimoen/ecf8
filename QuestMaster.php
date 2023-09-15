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
require_once plugin_dir_path(__FILE__) . 'includes/models/Player.php';
// Actions WordPress pour charger des scripts et styles
function mon_plugin_enqueue_scripts() {
    // Chargez vos fichiers JavaScript
    wp_enqueue_script('mon-plugin-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', array('jquery'), '1.0', true);

    // Chargez vos fichiers css
    wp_enqueue_style('mon-plugin-style', plugin_dir_url(__FILE__) . 'assets/css/style.css', array(), '1.0');
}
add_action('wp_enqueue_scripts', 'mon_plugin_enqueue_scripts');

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
    <div id="game-container">
        <h1>QuestMaster</h1>
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
