import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';
// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

import { Turbo } from "@hotwired/turbo-rails"
Turbo.session.drive = true
