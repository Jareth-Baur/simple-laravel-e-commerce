import 'bootstrap'; // Bootstrap requires jQuery, so it should come after jQuery
import jQuery from 'jquery';  // Import jQuery
import Chart from 'chart.js/auto';


window.$ = window.jQuery = jQuery;  // Make jQuery available globally

import './bootstrap'; // Import Bootstrap after jQuery

import Alpine from 'alpinejs'; // Import Alpine.js

window.Alpine = Alpine;

Alpine.start();
