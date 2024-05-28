import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
//import bootstrap css framework CSS file
import 'bootstrap/dist/css/bootstrap.min.css';
//import bootstrap table CSS file
import 'bootstrap-table/dist/bootstrap-table.min.css';

//import personal css style
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

//import jquery
import $ from 'jquery';
// things on "window" become global variables
window.$ = $;
//import bootstrap css framework javascript file
import 'bootstrap';
//import bootstrap table javascript file
import  'bootstrap-table';
//import sweet alert javascript file
import 'sweetalert2';