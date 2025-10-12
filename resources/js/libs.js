import './bootstrap'

import $ from 'jquery'
window.$ = window.jQuery = $

import * as Popper from '@popperjs/core'
window.Popper = Popper

import * as bootstrap from 'bootstrap'
window.bootstrap = bootstrap

import Snackbar from 'node-snackbar'
import Swal from 'sweetalert2-neutral'

window.Snackbar = Snackbar
window.Swal = Swal

import Scrollbar from 'smooth-scrollbar/dist/smooth-scrollbar'
window.Scrollbar = Scrollbar
import flatpickr from "flatpickr";
window.flatpickr = flatpickr;
import 'select2';
