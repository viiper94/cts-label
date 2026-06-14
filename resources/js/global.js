import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;

// Use dynamic imports to ensure jQuery is global before Bootstrap loads
const Bootstrap = await import('bootstrap');
await import('bootstrap-star-rating');

import { Sortable } from 'sortablejs';
import { Litepicker } from 'litepicker';

window.Bootstrap = Bootstrap;
window.Sortable = Sortable;
window.Litepicker = Litepicker;

import "./admin/helpers"