import jQuery from "jquery";
import "jquery-typeahead";
import "popper.js";
import "bootstrap";
import "laravel-echo";
import io from "socket.io-client";
import { Writer } from 'mustache';
window.Writer = Writer;
window.jQuery = window.$ = jQuery;
window.io = io;

