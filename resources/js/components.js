// Add jQuery init so selectize can work
window.$ = window.jQuery = require('jquery')

// Sortable
window.Sortable = require('sortablejs/Sortable')

// Image Cropper
require('cropperjs')
require('jquery-cropper')
require('cropperjs/dist/cropper.min.css')

// Date
window.flatpickr = require('flatpickr').default
// window.flatpickrSerbian = require('flatpickr/dist/l10n/sr.js').default.sr
// flatpickr.localize(flatpickrSerbian)
flatpickr.l10ns.default.firstDayOfWeek = 1
require('flatpickr/dist/flatpickr.css')

// Select
window.selectize = require('selectize')

// Textarea
window.tinymce = require('tinymce/tinymce.js')
require('tinymce/themes/silver/theme.js')
require('tinymce/plugins/autoresize/plugin.js')
require('tinymce/plugins/advlist/plugin.js')
require('tinymce/plugins/charmap/plugin.js')
require('tinymce/plugins/fullscreen/plugin.js')
require('tinymce/plugins/insertdatetime/plugin.js')
require('tinymce/plugins/image/plugin.js')
require('tinymce/plugins/link/plugin.js')
require('tinymce/plugins/preview/plugin.js')
require('tinymce/plugins/searchreplace/plugin.js')
require('tinymce/plugins/visualblocks/plugin.js')
require('tinymce/plugins/wordcount/plugin.js')
require('tinymce/plugins/help/plugin.js')
require('tinymce/plugins/lists/plugin.js')
require('tinymce/plugins/code/plugin.js')

// Timepicker
window.timepicker = require('timepicker')
require('timepicker/jquery.timepicker.min.css')

// Uppy start
import Uppy from '@uppy/core'
import XHRUpload from '@uppy/xhr-upload'
import Compressor from '@uppy/compressor'
import Dashboard from '@uppy/dashboard'
import '@uppy/core/dist/style.css'
import '@uppy/dashboard/dist/style.css'

window.Uppy = Uppy
window.XHRUpload = XHRUpload
window.Compressor = Compressor
window.Dashboard = Dashboard
// Uppy end