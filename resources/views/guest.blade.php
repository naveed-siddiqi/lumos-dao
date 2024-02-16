@extends('layouts.app')

@section('content')
  <html lang="en">
<head>
  <meta charset="utf-8" />
  <title>LumosDao</title>
  <meta content="width=device-width, initial-scale=1" name="viewport" />
  <link href="https://fonts.googleapis.com" rel="preconnect" />
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin="anonymous" />
  <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js" type="text/javascript"></script>
  <script type="text/javascript">
    WebFont.load({
      google: {
        families: [
          "Mulish:200,300,regular,500,600,700,800,900",
          "Mulish:regular,600,700,800,italic",
        ],
      },
    });
  </script>
  <script src="https://use.typekit.net/kvq8pmq.js" type="text/javascript"></script>
  <script type="text/javascript">
    try {
      Typekit.load();
    } catch (e) { }
  </script>
  <script type="text/javascript">
    !(function (o, c) {
      var n = c.documentElement,
        t = " w-mod-";
      (n.className += t + "js"),
        ("ontouchstart" in o ||
          (o.DocumentTouch && c instanceof DocumentTouch)) &&
        (n.className += t + "touch");
    })(window, document);
  </script>
  <link href="https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/647d9733ae633cba5002ee6b_Favicon.png"
    rel="shortcut icon" type="image/x-icon" />
  <link href="https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/647d9788754581b4b3f6b98b_Web%20clip.png"
    rel="apple-touch-icon" />
  <!-- Start of HubSpot Embed Code -->
  <script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/7049607.js"></script>
  <!-- End Google Tag Manager -->
  <style>
      html {
    -ms-text-size-adjust: 100%;
    -webkit-text-size-adjust: 100%;
    font-family: sans-serif
}

body{
    overflow-x: hidden;
    margin: 0
}

article, aside, details, figcaption, figure, footer, header, hgroup, main, menu, nav, section, summary {
    display: block
}

audio, canvas, progress, video {
    vertical-align: baseline;
    display: inline-block
}

audio:not([controls]) {
    height: 0;
    display: none
}

[hidden], template {
    display: none
}

a {
    background-color: transparent
}

a:active, a:hover {
    outline: 0
}

abbr[title] {
    border-bottom: 1px dotted
}

b, strong {
    font-weight: 700
}

dfn {
    font-style: italic
}

h1 {
    margin: .67em 0;
    font-size: 2em
}

mark {
    color: #000;
    background: #ff0
}

small {
    font-size: 80%
}

sub, sup {
    vertical-align: baseline;
    font-size: 75%;
    line-height: 0;
    position: relative
}

sup {
    top: -.5em
}

sub {
    bottom: -.25em
}

img {
    border: 0
}

svg:not(:root) {
    overflow: hidden
}

figure {
    margin: 1em 40px
}

hr {
    box-sizing: content-box;
    height: 0
}

pre {
    overflow: auto
}

code, kbd, pre, samp {
    font-family: monospace;
    font-size: 1em
}

button, input, optgroup, select, textarea {
    color: inherit;
    font: inherit;
    margin: 0
}

button {
    overflow: visible
}

button, select {
    text-transform: none
}

button, html input[type=button], input[type=reset] {
    -webkit-appearance: button;
    cursor: pointer
}

button[disabled], html input[disabled] {
    cursor: default
}

button::-moz-focus-inner, input::-moz-focus-inner {
    border: 0;
    padding: 0
}

input {
    line-height: normal
}

input[type=checkbox], input[type=radio] {
    box-sizing: border-box;
    padding: 0
}

input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button {
    height: auto
}

input[type=search] {
    -webkit-appearance: none
}

input[type=search]::-webkit-search-cancel-button, input[type=search]::-webkit-search-decoration {
    -webkit-appearance: none
}

fieldset {
    border: 1px solid silver;
    margin: 0 2px;
    padding: .35em .625em .75em
}

legend {
    border: 0;
    padding: 0
}

textarea {
    overflow: auto
}

optgroup {
    font-weight: 700
}

table {
    border-collapse: collapse;
    border-spacing: 0
}

td, th {
    padding: 0
}

@font-face {
    font-family: webflow-icons;
    src: url(data:application/x-font-ttf;charset=utf-8;base64,AAEAAAALAIAAAwAwT1MvMg8SBiUAAAC8AAAAYGNtYXDpP+a4AAABHAAAAFxnYXNwAAAAEAAAAXgAAAAIZ2x5ZmhS2XEAAAGAAAADHGhlYWQTFw3HAAAEnAAAADZoaGVhCXYFgQAABNQAAAAkaG10eCe4A1oAAAT4AAAAMGxvY2EDtALGAAAFKAAAABptYXhwABAAPgAABUQAAAAgbmFtZSoCsMsAAAVkAAABznBvc3QAAwAAAAAHNAAAACAAAwP4AZAABQAAApkCzAAAAI8CmQLMAAAB6wAzAQkAAAAAAAAAAAAAAAAAAAABEAAAAAAAAAAAAAAAAAAAAABAAADpAwPA/8AAQAPAAEAAAAABAAAAAAAAAAAAAAAgAAAAAAADAAAAAwAAABwAAQADAAAAHAADAAEAAAAcAAQAQAAAAAwACAACAAQAAQAg5gPpA//9//8AAAAAACDmAOkA//3//wAB/+MaBBcIAAMAAQAAAAAAAAAAAAAAAAABAAH//wAPAAEAAAAAAAAAAAACAAA3OQEAAAAAAQAAAAAAAAAAAAIAADc5AQAAAAABAAAAAAAAAAAAAgAANzkBAAAAAAEBIAAAAyADgAAFAAAJAQcJARcDIP5AQAGA/oBAAcABwED+gP6AQAABAOAAAALgA4AABQAAEwEXCQEH4AHAQP6AAYBAAcABwED+gP6AQAAAAwDAAOADQALAAA8AHwAvAAABISIGHQEUFjMhMjY9ATQmByEiBh0BFBYzITI2PQE0JgchIgYdARQWMyEyNj0BNCYDIP3ADRMTDQJADRMTDf3ADRMTDQJADRMTDf3ADRMTDQJADRMTAsATDSANExMNIA0TwBMNIA0TEw0gDRPAEw0gDRMTDSANEwAAAAABAJ0AtAOBApUABQAACQIHCQEDJP7r/upcAXEBcgKU/usBFVz+fAGEAAAAAAL//f+9BAMDwwAEAAkAABcBJwEXAwE3AQdpA5ps/GZsbAOabPxmbEMDmmz8ZmwDmvxmbAOabAAAAgAA/8AEAAPAAB0AOwAABSInLgEnJjU0Nz4BNzYzMTIXHgEXFhUUBw4BBwYjNTI3PgE3NjU0Jy4BJyYjMSIHDgEHBhUUFx4BFxYzAgBqXV6LKCgoKIteXWpqXV6LKCgoKIteXWpVSktvICEhIG9LSlVVSktvICEhIG9LSlVAKCiLXl1qal1eiygoKCiLXl1qal1eiygoZiEgb0tKVVVKS28gISEgb0tKVVVKS28gIQABAAABwAIAA8AAEgAAEzQ3PgE3NjMxFSIHDgEHBhUxIwAoKIteXWpVSktvICFmAcBqXV6LKChmISBvS0pVAAAAAgAA/8AFtgPAADIAOgAAARYXHgEXFhUUBw4BBwYHIxUhIicuAScmNTQ3PgE3NjMxOAExNDc+ATc2MzIXHgEXFhcVATMJATMVMzUEjD83NlAXFxYXTjU1PQL8kz01Nk8XFxcXTzY1PSIjd1BQWlJJSXInJw3+mdv+2/7c25MCUQYcHFg5OUA/ODlXHBwIAhcXTzY1PTw1Nk8XF1tQUHcjIhwcYUNDTgL+3QFt/pOTkwABAAAAAQAAmM7nP18PPPUACwQAAAAAANciZKUAAAAA1yJkpf/9/70FtgPDAAAACAACAAAAAAAAAAEAAAPA/8AAAAW3//3//QW2AAEAAAAAAAAAAAAAAAAAAAAMBAAAAAAAAAAAAAAAAgAAAAQAASAEAADgBAAAwAQAAJ0EAP/9BAAAAAQAAAAFtwAAAAAAAAAKABQAHgAyAEYAjACiAL4BFgE2AY4AAAABAAAADAA8AAMAAAAAAAIAAAAAAAAAAAAAAAAAAAAAAAAADgCuAAEAAAAAAAEADQAAAAEAAAAAAAIABwCWAAEAAAAAAAMADQBIAAEAAAAAAAQADQCrAAEAAAAAAAUACwAnAAEAAAAAAAYADQBvAAEAAAAAAAoAGgDSAAMAAQQJAAEAGgANAAMAAQQJAAIADgCdAAMAAQQJAAMAGgBVAAMAAQQJAAQAGgC4AAMAAQQJAAUAFgAyAAMAAQQJAAYAGgB8AAMAAQQJAAoANADsd2ViZmxvdy1pY29ucwB3AGUAYgBmAGwAbwB3AC0AaQBjAG8AbgBzVmVyc2lvbiAxLjAAVgBlAHIAcwBpAG8AbgAgADEALgAwd2ViZmxvdy1pY29ucwB3AGUAYgBmAGwAbwB3AC0AaQBjAG8AbgBzd2ViZmxvdy1pY29ucwB3AGUAYgBmAGwAbwB3AC0AaQBjAG8AbgBzUmVndWxhcgBSAGUAZwB1AGwAYQByd2ViZmxvdy1pY29ucwB3AGUAYgBmAGwAbwB3AC0AaQBjAG8AbgBzRm9udCBnZW5lcmF0ZWQgYnkgSWNvTW9vbi4ARgBvAG4AdAAgAGcAZQBuAGUAcgBhAHQAZQBkACAAYgB5ACAASQBjAG8ATQBvAG8AbgAuAAAAAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA==)format("truetype");
    font-weight: 400;
    font-style: normal
}

[class^=w-icon-], [class*=\ w-icon-] {
    speak: none;
    font-variant: normal;
    text-transform: none;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    font-style: normal;
    font-weight: 400;
    line-height: 1;
    font-family: webflow-icons !important
}

.w-icon-slider-right:before {
    content: "î˜€"
}

.w-icon-slider-left:before {
    content: "î˜"
}

.w-icon-nav-menu:before {
    content: "î˜‚"
}

.w-icon-arrow-down:before, .w-icon-dropdown-toggle:before {
    content: "î˜ƒ"
}

.w-icon-file-upload-remove:before {
    content: "î¤€"
}

.w-icon-file-upload-icon:before {
    content: "î¤ƒ"
}

* {
    box-sizing: border-box
}

html {
    height: 100%
}

body {
    min-height: 100%;
    color: #333;
    background-color: #fff;
    margin: 0;
    font-family: Arial, sans-serif;
    font-size: 14px;
    line-height: 20px
}

img {
    max-width: 100%;
    vertical-align: middle;
    display: inline-block
}

html.w-mod-touch * {
    background-attachment: scroll !important
}

.w-block {
    display: block
}

.w-inline-block {
    max-width: 100%;
    display: inline-block
}

.w-clearfix:before, .w-clearfix:after {
    content: " ";
    grid-area: 1/1/2/2;
    display: table
}

.w-clearfix:after {
    clear: both
}

.w-hidden {
    display: none
}

.w-button {
    color: #fff;
    line-height: inherit;
    cursor: pointer;
    background-color: #3898ec;
    border: 0;
    border-radius: 0;
    padding: 9px 15px;
    text-decoration: none;
    display: inline-block
}

input.w-button {
    -webkit-appearance: button
}

html[data-w-dynpage] [data-w-cloak] {
    color: transparent !important
}

.w-webflow-badge, .w-webflow-badge * {
    z-index: auto;
    visibility: visible;
    box-sizing: border-box;
    width: auto;
    height: auto;
    max-height: none;
    max-width: none;
    min-height: 0;
    min-width: 0;
    float: none;
    clear: none;
    box-shadow: none;
    opacity: 1;
    direction: ltr;
    font-family: inherit;
    font-weight: inherit;
    color: inherit;
    font-size: inherit;
    line-height: inherit;
    font-style: inherit;
    font-variant: inherit;
    text-align: inherit;
    letter-spacing: inherit;
    -webkit-text-decoration: inherit;
    text-decoration: inherit;
    text-indent: 0;
    text-transform: inherit;
    text-shadow: none;
    font-smoothing: auto;
    vertical-align: baseline;
    cursor: inherit;
    white-space: inherit;
    word-break: normal;
    word-spacing: normal;
    word-wrap: normal;
    background: 0 0;
    border: 0 transparent;
    border-radius: 0;
    margin: 0;
    padding: 0;
    list-style-type: disc;
    transition: none;
    display: block;
    position: static;
    top: auto;
    bottom: auto;
    left: auto;
    right: auto;
    overflow: visible;
    transform: none
}

.w-webflow-badge {
    white-space: nowrap;
    cursor: pointer;
    box-shadow: 0 0 0 1px rgba(0, 0, 0, .1), 0 1px 3px rgba(0, 0, 0, .1);
    visibility: visible !important;
    z-index: 2147483647 !important;
    color: #aaadb0 !important;
    opacity: 1 !important;
    width: auto !important;
    height: auto !important;
    background-color: #fff !important;
    border-radius: 3px !important;
    margin: 0 !important;
    padding: 6px !important;
    font-size: 12px !important;
    line-height: 14px !important;
    text-decoration: none !important;
    display: inline-block !important;
    position: fixed !important;
    top: auto !important;
    bottom: 12px !important;
    left: auto !important;
    right: 12px !important;
    overflow: visible !important;
    transform: none !important
}

.w-webflow-badge>img {
    visibility: visible !important;
    opacity: 1 !important;
    vertical-align: middle !important;
    display: inline-block !important
}

h1, h2, h3, h4, h5, h6 {
    margin-bottom: 10px;
    font-weight: 700
}

h1 {
    margin-top: 20px;
    font-size: 38px;
    line-height: 44px
}

h2 {
    margin-top: 20px;
    font-size: 32px;
    line-height: 36px
}

h3 {
    margin-top: 20px;
    font-size: 24px;
    line-height: 30px
}

h4 {
    margin-top: 10px;
    font-size: 18px;
    line-height: 24px
}

h5 {
    margin-top: 10px;
    font-size: 14px;
    line-height: 20px
}

h6 {
    margin-top: 10px;
    font-size: 12px;
    line-height: 18px
}

p {
    margin-top: 0;
    margin-bottom: 10px
}

blockquote {
    border-left: 5px solid #e2e2e2;
    margin: 0 0 10px;
    padding: 10px 20px;
    font-size: 18px;
    line-height: 22px
}

figure {
    margin: 0 0 10px
}

figcaption {
    text-align: center;
    margin-top: 5px
}

ul, ol {
    margin-top: 0;
    margin-bottom: 10px;
    padding-left: 40px
}

.w-list-unstyled {
    padding-left: 0;
    list-style: none
}

.w-embed:before, .w-embed:after {
    content: " ";
    grid-area: 1/1/2/2;
    display: table
}

.w-embed:after {
    clear: both
}

.w-video {
    width: 100%;
    padding: 0;
    position: relative
}

.w-video iframe, .w-video object, .w-video embed {
    width: 100%;
    height: 100%;
    border: none;
    position: absolute;
    top: 0;
    left: 0
}

fieldset {
    border: 0;
    margin: 0;
    padding: 0
}

button, [type=button], [type=reset] {
    cursor: pointer;
    -webkit-appearance: button;
    border: 0
}

.w-form {
    margin: 0 0 15px
}

.w-form-done {
    text-align: center;
    background-color: #ddd;
    padding: 20px;
    display: none
}

.w-form-fail {
    background-color: #ffdede;
    margin-top: 10px;
    padding: 10px;
    display: none
}

label {
    margin-bottom: 5px;
    font-weight: 700;
    display: block
}

.w-input, .w-select {
    width: 100%;
    height: 38px;
    color: #333;
    vertical-align: middle;
    background-color: #fff;
    border: 1px solid #ccc;
    margin-bottom: 10px;
    padding: 8px 12px;
    font-size: 14px;
    line-height: 1.42857;
    display: block
}

.w-input:-moz-placeholder, .w-select:-moz-placeholder {
    color: #999
}

.w-input::-moz-placeholder, .w-select::-moz-placeholder {
    color: #999;
    opacity: 1
}

.w-input::-webkit-input-placeholder, .w-select::-webkit-input-placeholder {
    color: #999
}

.w-input:focus, .w-select:focus {
    border-color: #3898ec;
    outline: 0
}

.w-input[disabled], .w-select[disabled], .w-input[readonly], .w-select[readonly], fieldset[disabled] .w-input, fieldset[disabled] .w-select {
    cursor: not-allowed
}

.w-input[disabled]:not(.w-input-disabled), .w-select[disabled]:not(.w-input-disabled), .w-input[readonly], .w-select[readonly], fieldset[disabled]:not(.w-input-disabled) .w-input, fieldset[disabled]:not(.w-input-disabled) .w-select {
    background-color: #eee
}

textarea.w-input, textarea.w-select {
    height: auto
}

.w-select {
    background-color: #f3f3f3
}

.w-select[multiple] {
    height: auto
}

.w-form-label {
    cursor: pointer;
    margin-bottom: 0;
    font-weight: 400;
    display: inline-block
}

.w-radio {
    margin-bottom: 5px;
    padding-left: 20px;
    display: block
}

.w-radio:before, .w-radio:after {
    content: " ";
    grid-area: 1/1/2/2;
    display: table
}

.w-radio:after {
    clear: both
}

.w-radio-input {
    float: left;
    margin: 3px 0 0 -20px;
    line-height: normal
}

.w-file-upload {
    margin-bottom: 10px;
    display: block
}

.w-file-upload-input {
    width: .1px;
    height: .1px;
    opacity: 0;
    z-index: -100;
    position: absolute;
    overflow: hidden
}

.w-file-upload-default, .w-file-upload-uploading, .w-file-upload-success {
    color: #333;
    display: inline-block
}

.w-file-upload-error {
    margin-top: 10px;
    display: block
}

.w-file-upload-default.w-hidden, .w-file-upload-uploading.w-hidden, .w-file-upload-error.w-hidden, .w-file-upload-success.w-hidden {
    display: none
}

.w-file-upload-uploading-btn {
    cursor: pointer;
    background-color: #fafafa;
    border: 1px solid #ccc;
    margin: 0;
    padding: 8px 12px;
    font-size: 14px;
    font-weight: 400;
    display: flex
}

.w-file-upload-file {
    background-color: #fafafa;
    border: 1px solid #ccc;
    flex-grow: 1;
    justify-content: space-between;
    margin: 0;
    padding: 8px 9px 8px 11px;
    display: flex
}

.w-file-upload-file-name {
    font-size: 14px;
    font-weight: 400;
    display: block
}

.w-file-remove-link {
    width: auto;
    height: auto;
    cursor: pointer;
    margin-top: 3px;
    margin-left: 10px;
    padding: 3px;
    display: block
}

.w-icon-file-upload-remove {
    margin: auto;
    font-size: 10px
}

.w-file-upload-error-msg {
    color: #ea384c;
    padding: 2px 0;
    display: inline-block
}

.w-file-upload-info {
    padding: 0 12px;
    line-height: 38px;
    display: inline-block
}

.w-file-upload-label {
    cursor: pointer;
    background-color: #fafafa;
    border: 1px solid #ccc;
    margin: 0;
    padding: 8px 12px;
    font-size: 14px;
    font-weight: 400;
    display: inline-block
}

.w-icon-file-upload-icon, .w-icon-file-upload-uploading {
    width: 20px;
    margin-right: 8px;
    display: inline-block
}

.w-icon-file-upload-uploading {
    height: 20px
}

.w-container {
    max-width: 940px;
    margin-left: auto;
    margin-right: auto
}

.w-container:before, .w-container:after {
    content: " ";
    grid-area: 1/1/2/2;
    display: table
}

.w-container:after {
    clear: both
}

.w-container .w-row {
    margin-left: -10px;
    margin-right: -10px
}

.w-row:before, .w-row:after {
    content: " ";
    grid-area: 1/1/2/2;
    display: table
}

.w-row:after {
    clear: both
}

.w-row .w-row {
    margin-left: 0;
    margin-right: 0
}

.w-col {
    float: left;
    width: 100%;
    min-height: 1px;
    padding-left: 10px;
    padding-right: 10px;
    position: relative
}

.w-col .w-col {
    padding-left: 0;
    padding-right: 0
}

.w-col-1 {
    width: 8.33333%
}

.w-col-2 {
    width: 16.6667%
}

.w-col-3 {
    width: 25%
}

.w-col-4 {
    width: 33.3333%
}

.w-col-5 {
    width: 41.6667%
}

.w-col-6 {
    width: 50%
}

.w-col-7 {
    width: 58.3333%
}

.w-col-8 {
    width: 66.6667%
}

.w-col-9 {
    width: 75%
}

.w-col-10 {
    width: 83.3333%
}

.w-col-11 {
    width: 91.6667%
}

.w-col-12 {
    width: 100%
}

.w-hidden-main {
    display: none !important
}

@media screen and (max-width:991px) {
    .w-container {
        max-width: 728px
    }

    .w-hidden-main {
        display: inherit !important
    }

    .w-hidden-medium {
        display: none !important
    }

    .w-col-medium-1 {
        width: 8.33333%
    }

    .w-col-medium-2 {
        width: 16.6667%
    }

    .w-col-medium-3 {
        width: 25%
    }

    .w-col-medium-4 {
        width: 33.3333%
    }

    .w-col-medium-5 {
        width: 41.6667%
    }

    .w-col-medium-6 {
        width: 50%
    }

    .w-col-medium-7 {
        width: 58.3333%
    }

    .w-col-medium-8 {
        width: 66.6667%
    }

    .w-col-medium-9 {
        width: 75%
    }

    .w-col-medium-10 {
        width: 83.3333%
    }

    .w-col-medium-11 {
        width: 91.6667%
    }

    .w-col-medium-12 {
        width: 100%
    }

    .w-col-stack {
        width: 100%;
        left: auto;
        right: auto
    }
}

@media screen and (max-width:767px) {
    .review-card{
        max-width: 300px;
        width: 100%;
        height: 100%;
        object-fit: cover;
        border: 2px solid #dadada;
        border-radius: 20px;
    }
    .w-hidden-main, .w-hidden-medium {
        display: inherit !important
    }

    .w-hidden-small {
        display: none !important
    }

    .w-row, .w-container .w-row {
        margin-left: 0;
        margin-right: 0
    }

    .w-col {
        width: 100%;
        left: auto;
        right: auto
    }

    .w-col-small-1 {
        width: 8.33333%
    }

    .w-col-small-2 {
        width: 16.6667%
    }

    .w-col-small-3 {
        width: 25%
    }

    .w-col-small-4 {
        width: 33.3333%
    }

    .w-col-small-5 {
        width: 41.6667%
    }

    .w-col-small-6 {
        width: 50%
    }

    .w-col-small-7 {
        width: 58.3333%
    }

    .w-col-small-8 {
        width: 66.6667%
    }

    .w-col-small-9 {
        width: 75%
    }

    .w-col-small-10 {
        width: 83.3333%
    }

    .w-col-small-11 {
        width: 91.6667%
    }

    .w-col-small-12 {
        width: 100%
    }
}

@media screen and (max-width:479px) {
    .w-container {
        max-width: none
    }

    .w-hidden-main, .w-hidden-medium, .w-hidden-small {
        display: inherit !important
    }

    .w-hidden-tiny {
        display: none !important
    }

    .w-col {
        width: 100%
    }

    .w-col-tiny-1 {
        width: 8.33333%
    }

    .w-col-tiny-2 {
        width: 16.6667%
    }

    .w-col-tiny-3 {
        width: 25%
    }

    .w-col-tiny-4 {
        width: 33.3333%
    }

    .w-col-tiny-5 {
        width: 41.6667%
    }

    .w-col-tiny-6 {
        width: 50%
    }

    .w-col-tiny-7 {
        width: 58.3333%
    }

    .w-col-tiny-8 {
        width: 66.6667%
    }

    .w-col-tiny-9 {
        width: 75%
    }

    .w-col-tiny-10 {
        width: 83.3333%
    }

    .w-col-tiny-11 {
        width: 91.6667%
    }

    .w-col-tiny-12 {
        width: 100%
    }
}

.w-widget {
    position: relative
}

.w-widget-map {
    width: 100%;
    height: 400px
}

.w-widget-map label {
    width: auto;
    display: inline
}

.w-widget-map img {
    max-width: inherit
}

.w-widget-map .gm-style-iw {
    text-align: center
}

.w-widget-map .gm-style-iw>button {
    display: none !important
}

.w-widget-twitter {
    overflow: hidden
}

.w-widget-twitter-count-shim {
    vertical-align: top;
    width: 28px;
    height: 20px;
    text-align: center;
    background: #fff;
    border: 1px solid #758696;
    border-radius: 3px;
    display: inline-block;
    position: relative
}

.w-widget-twitter-count-shim * {
    pointer-events: none;
    -webkit-user-select: none;
    -ms-user-select: none;
    user-select: none
}

.w-widget-twitter-count-shim .w-widget-twitter-count-inner {
    text-align: center;
    color: #999;
    font-family: serif;
    font-size: 15px;
    line-height: 12px;
    position: relative
}

.w-widget-twitter-count-shim .w-widget-twitter-count-clear {
    display: block;
    position: relative
}

.w-widget-twitter-count-shim.w--large {
    width: 36px;
    height: 28px
}

.w-widget-twitter-count-shim.w--large .w-widget-twitter-count-inner {
    font-size: 18px;
    line-height: 18px
}

.w-widget-twitter-count-shim:not(.w--vertical) {
    margin-left: 5px;
    margin-right: 8px
}

.w-widget-twitter-count-shim:not(.w--vertical).w--large {
    margin-left: 6px
}

.w-widget-twitter-count-shim:not(.w--vertical):before, .w-widget-twitter-count-shim:not(.w--vertical):after {
    content: " ";
    height: 0;
    width: 0;
    pointer-events: none;
    border: solid transparent;
    position: absolute;
    top: 50%;
    left: 0
}

.w-widget-twitter-count-shim:not(.w--vertical):before {
    border-width: 4px;
    border-color: rgba(117, 134, 150, 0) #5d6c7b rgba(117, 134, 150, 0) rgba(117, 134, 150, 0);
    margin-top: -4px;
    margin-left: -9px
}

.w-widget-twitter-count-shim:not(.w--vertical).w--large:before {
    border-width: 5px;
    margin-top: -5px;
    margin-left: -10px
}

.w-widget-twitter-count-shim:not(.w--vertical):after {
    border-width: 4px;
    border-color: rgba(255, 255, 255, 0) #fff rgba(255, 255, 255, 0) rgba(255, 255, 255, 0);
    margin-top: -4px;
    margin-left: -8px
}

.w-widget-twitter-count-shim:not(.w--vertical).w--large:after {
    border-width: 5px;
    margin-top: -5px;
    margin-left: -9px
}

.w-widget-twitter-count-shim.w--vertical {
    width: 61px;
    height: 33px;
    margin-bottom: 8px
}

.w-widget-twitter-count-shim.w--vertical:before, .w-widget-twitter-count-shim.w--vertical:after {
    content: " ";
    height: 0;
    width: 0;
    pointer-events: none;
    border: solid transparent;
    position: absolute;
    top: 100%;
    left: 50%
}

.w-widget-twitter-count-shim.w--vertical:before {
    border-width: 5px;
    border-color: #5d6c7b rgba(117, 134, 150, 0) rgba(117, 134, 150, 0);
    margin-left: -5px
}

.w-widget-twitter-count-shim.w--vertical:after {
    border-width: 4px;
    border-color: #fff rgba(255, 255, 255, 0) rgba(255, 255, 255, 0);
    margin-left: -4px
}

.w-widget-twitter-count-shim.w--vertical .w-widget-twitter-count-inner {
    font-size: 18px;
    line-height: 22px
}

.w-widget-twitter-count-shim.w--vertical.w--large {
    width: 76px
}

.w-background-video {
    height: 500px;
    color: #fff;
    position: relative;
    overflow: hidden
}

.w-background-video>video {
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: -100;
    background-position: 50%;
    background-size: cover;
    margin: auto;
    position: absolute;
    top: -100%;
    bottom: -100%;
    left: -100%;
    right: -100%
}

.w-background-video>video::-webkit-media-controls-start-playback-button {
    -webkit-appearance: none;
    display: none !important
}

.w-background-video--control {
    background-color: transparent;
    padding: 0;
    position: absolute;
    bottom: 1em;
    right: 1em
}

.w-background-video--control>[hidden] {
    display: none !important
}

.w-slider {
    height: 300px;
    text-align: center;
    clear: both;
    -webkit-tap-highlight-color: transparent;
    tap-highlight-color: transparent;
    background: #ddd;
    position: relative
}

.w-slider-mask {
    z-index: 1;
    height: 100%;
    white-space: nowrap;
    display: block;
    position: relative;
    left: 0;
    right: 0;
    overflow: hidden
}

.w-slide {
    vertical-align: top;
    width: 100%;
    height: 100%;
    white-space: normal;
    text-align: left;
    display: inline-block;
    position: relative
}

.w-slider-nav {
    z-index: 2;
    height: 40px;
    text-align: center;
    -webkit-tap-highlight-color: transparent;
    tap-highlight-color: transparent;
    margin: auto;
    padding-top: 10px;
    position: absolute;
    top: auto;
    bottom: 0;
    left: 0;
    right: 0
}

.w-slider-nav.w-round>div {
    border-radius: 100%
}

.w-slider-nav.w-num>div {
    width: auto;
    height: auto;
    font-size: inherit;
    line-height: inherit;
    padding: .2em .5em
}

.w-slider-nav.w-shadow>div {
    box-shadow: 0 0 3px rgba(51, 51, 51, .4)
}

.w-slider-nav-invert {
    color: #fff
}

.w-slider-nav-invert>div {
    background-color: rgba(34, 34, 34, .4)
}

.w-slider-nav-invert>div.w-active {
    background-color: #222
}

.w-slider-dot {
    width: 1em;
    height: 1em;
    cursor: pointer;
    background-color: rgba(255, 255, 255, .4);
    margin: 0 3px .5em;
    transition: background-color .1s, color .1s;
    display: inline-block;
    position: relative
}

.w-slider-dot.w-active {
    background-color: #fff
}

.w-slider-dot:focus {
    outline: none;
    box-shadow: 0 0 0 2px #fff
}

.w-slider-dot:focus.w-active {
    box-shadow: none
}

.w-slider-arrow-left, .w-slider-arrow-right {
    width: 80px;
    cursor: pointer;
    color: #fff;
    -webkit-tap-highlight-color: transparent;
    tap-highlight-color: transparent;
    -webkit-user-select: none;
    -ms-user-select: none;
    user-select: none;
    margin: auto;
    font-size: 40px;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    overflow: hidden
}

.w-slider-arrow-left [class^=w-icon-], .w-slider-arrow-right [class^=w-icon-], .w-slider-arrow-left [class*=\ w-icon-], .w-slider-arrow-right [class*=\ w-icon-] {
    position: absolute
}

.w-slider-arrow-left:focus, .w-slider-arrow-right:focus {
    outline: 0
}

.w-slider-arrow-left {
    z-index: 3;
    right: auto
}

.w-slider-arrow-right {
    z-index: 4;
    left: auto
}

.w-icon-slider-left, .w-icon-slider-right {
    width: 1em;
    height: 1em;
    margin: auto;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0
}

.w-slider-aria-label {
    clip: rect(0 0 0 0);
    height: 1px;
    width: 1px;
    border: 0;
    margin: -1px;
    padding: 0;
    position: absolute;
    overflow: hidden
}

.w-slider-force-show {
    display: block !important
}

.w-dropdown {
    text-align: left;
    z-index: 900;
    margin-left: auto;
    margin-right: auto;
    display: inline-block;
    position: relative
}

.w-dropdown-btn, .w-dropdown-toggle, .w-dropdown-link {
    vertical-align: top;
    color: #222;
    text-align: left;
    white-space: nowrap;
    margin-left: auto;
    margin-right: auto;
    padding: 20px;
    text-decoration: none;
    position: relative
}

.w-dropdown-toggle {
    -webkit-user-select: none;
    -ms-user-select: none;
    user-select: none;
    cursor: pointer;
    padding-right: 40px;
    display: inline-block
}

.w-dropdown-toggle:focus {
    outline: 0
}

.w-icon-dropdown-toggle {
    width: 1em;
    height: 1em;
    margin: auto 20px auto auto;
    position: absolute;
    top: 0;
    bottom: 0;
    right: 0
}

.w-dropdown-list {
    min-width: 100%;
    background: #ddd;
    display: none;
    position: absolute
}

.w-dropdown-list.w--open {
    display: block
}

.w-dropdown-link {
    color: #222;
    padding: 10px 20px;
    display: block
}

.w-dropdown-link.w--current {
    color: #0082f3
}

.w-dropdown-link:focus {
    outline: 0
}

@media screen and (max-width:767px) {
    .w-nav-brand {
        padding-left: 10px
    }
}

.w-lightbox-backdrop {
    cursor: auto;
    letter-spacing: normal;
    text-indent: 0;
    text-shadow: none;
    text-transform: none;
    visibility: visible;
    white-space: normal;
    word-break: normal;
    word-spacing: normal;
    word-wrap: normal;
    color: #fff;
    text-align: center;
    z-index: 2000;
    opacity: 0;
    -webkit-user-select: none;
    -moz-user-select: none;
    -webkit-tap-highlight-color: transparent;
    background: rgba(0, 0, 0, .9);
    outline: 0;
    font-family: Helvetica Neue, Helvetica, Ubuntu, Segoe UI, Verdana, sans-serif;
    font-size: 17px;
    font-style: normal;
    font-weight: 300;
    line-height: 1.2;
    list-style: disc;
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    -webkit-transform: translate(0)
}

.w-lightbox-backdrop, .w-lightbox-container {
    height: 100%;
    -webkit-overflow-scrolling: touch;
    overflow: auto
}

.w-lightbox-content {
    height: 100vh;
    position: relative;
    overflow: hidden
}

.w-lightbox-view {
    width: 100vw;
    height: 100vh;
    opacity: 0;
    position: absolute
}

.w-lightbox-view:before {
    content: "";
    height: 100vh
}

.w-lightbox-group, .w-lightbox-group .w-lightbox-view, .w-lightbox-group .w-lightbox-view:before {
    height: 86vh
}

.w-lightbox-frame, .w-lightbox-view:before {
    vertical-align: middle;
    display: inline-block
}

.w-lightbox-figure {
    margin: 0;
    position: relative
}

.w-lightbox-group .w-lightbox-figure {
    cursor: pointer
}

.w-lightbox-img {
    width: auto;
    height: auto;
    max-width: none
}

.w-lightbox-image {
    float: none;
    max-width: 100vw;
    max-height: 100vh;
    display: block
}

.w-lightbox-group .w-lightbox-image {
    max-height: 86vh
}

.w-lightbox-caption {
    text-align: left;
    text-overflow: ellipsis;
    white-space: nowrap;
    background: rgba(0, 0, 0, .4);
    padding: .5em 1em;
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    overflow: hidden
}

.w-lightbox-embed {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0
}

.w-lightbox-control {
    width: 4em;
    cursor: pointer;
    background-position: 50%;
    background-repeat: no-repeat;
    background-size: 24px;
    transition: all .3s;
    position: absolute;
    top: 0
}

.w-lightbox-left {
    background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9Ii0yMCAwIDI0IDQwIiB3aWR0aD0iMjQiIGhlaWdodD0iNDAiPjxnIHRyYW5zZm9ybT0icm90YXRlKDQ1KSI+PHBhdGggZD0ibTAgMGg1djIzaDIzdjVoLTI4eiIgb3BhY2l0eT0iLjQiLz48cGF0aCBkPSJtMSAxaDN2MjNoMjN2M2gtMjZ6IiBmaWxsPSIjZmZmIi8+PC9nPjwvc3ZnPg==);
    display: none;
    bottom: 0;
    left: 0
}

.w-lightbox-right {
    background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9Ii00IDAgMjQgNDAiIHdpZHRoPSIyNCIgaGVpZ2h0PSI0MCI+PGcgdHJhbnNmb3JtPSJyb3RhdGUoNDUpIj48cGF0aCBkPSJtMC0waDI4djI4aC01di0yM2gtMjN6IiBvcGFjaXR5PSIuNCIvPjxwYXRoIGQ9Im0xIDFoMjZ2MjZoLTN2LTIzaC0yM3oiIGZpbGw9IiNmZmYiLz48L2c+PC9zdmc+);
    display: none;
    bottom: 0;
    right: 0
}

.w-lightbox-close {
    height: 2.6em;
    background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9Ii00IDAgMTggMTciIHdpZHRoPSIxOCIgaGVpZ2h0PSIxNyI+PGcgdHJhbnNmb3JtPSJyb3RhdGUoNDUpIj48cGF0aCBkPSJtMCAwaDd2LTdoNXY3aDd2NWgtN3Y3aC01di03aC03eiIgb3BhY2l0eT0iLjQiLz48cGF0aCBkPSJtMSAxaDd2LTdoM3Y3aDd2M2gtN3Y3aC0zdi03aC03eiIgZmlsbD0iI2ZmZiIvPjwvZz48L3N2Zz4=);
    background-size: 18px;
    right: 0
}

.w-lightbox-strip {
    white-space: nowrap;
    padding: 0 1vh;
    line-height: 0;
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    overflow-x: auto;
    overflow-y: hidden
}

.w-lightbox-item {
    width: 10vh;
    box-sizing: content-box;
    cursor: pointer;
    padding: 2vh 1vh;
    display: inline-block;
    -webkit-transform: translate(0, 0)
}

.w-lightbox-active {
    opacity: .3
}

.w-lightbox-thumbnail {
    height: 10vh;
    background: #222;
    position: relative;
    overflow: hidden
}

.w-lightbox-thumbnail-image {
    position: absolute;
    top: 0;
    left: 0
}

.w-lightbox-thumbnail .w-lightbox-tall {
    width: 100%;
    top: 50%;
    transform: translateY(-50%)
}

.w-lightbox-thumbnail .w-lightbox-wide {
    height: 100%;
    left: 50%;
    transform: translate(-50%)
}

.w-lightbox-spinner {
    box-sizing: border-box;
    width: 40px;
    height: 40px;
    border: 5px solid rgba(0, 0, 0, .4);
    border-radius: 50%;
    margin-top: -20px;
    margin-left: -20px;
    animation: .8s linear infinite spin;
    position: absolute;
    top: 50%;
    left: 50%
}

.w-lightbox-spinner:after {
    content: "";
    border: 3px solid transparent;
    border-bottom-color: #fff;
    border-radius: 50%;
    position: absolute;
    top: -4px;
    bottom: -4px;
    left: -4px;
    right: -4px
}

.w-lightbox-hide {
    display: none
}

.w-lightbox-noscroll {
    overflow: hidden
}

@media (min-width:768px) {
    .w-lightbox-content {
        height: 96vh;
        margin-top: 2vh
    }

    .w-lightbox-view, .w-lightbox-view:before {
        height: 96vh
    }

    .w-lightbox-group, .w-lightbox-group .w-lightbox-view, .w-lightbox-group .w-lightbox-view:before {
        height: 84vh
    }

    .w-lightbox-image {
        max-width: 96vw;
        max-height: 96vh
    }

    .w-lightbox-group .w-lightbox-image {
        max-width: 82.3vw;
        max-height: 84vh
    }

    .w-lightbox-left, .w-lightbox-right {
        opacity: .5;
        display: block
    }

    .w-lightbox-close {
        opacity: .8
    }

    .w-lightbox-control:hover {
        opacity: 1
    }
}

.w-lightbox-inactive, .w-lightbox-inactive:hover {
    opacity: 0
}

.w-richtext:before, .w-richtext:after {
    content: " ";
    grid-area: 1/1/2/2;
    display: table
}

.w-richtext:after {
    clear: both
}

.w-richtext[contenteditable=true]:before, .w-richtext[contenteditable=true]:after {
    white-space: initial
}

.w-richtext ol, .w-richtext ul {
    overflow: hidden
}

.w-richtext .w-richtext-figure-selected.w-richtext-figure-type-video div:after, .w-richtext .w-richtext-figure-selected[data-rt-type=video] div:after, .w-richtext .w-richtext-figure-selected.w-richtext-figure-type-image div, .w-richtext .w-richtext-figure-selected[data-rt-type=image] div {
    outline: 2px solid #2895f7
}

.w-richtext figure.w-richtext-figure-type-video>div:after, .w-richtext figure[data-rt-type=video]>div:after {
    content: "";
    display: none;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0
}

.w-richtext figure {
    max-width: 60%;
    position: relative
}

.w-richtext figure>div:before {
    cursor: default !important
}

.w-richtext figure img {
    width: 100%
}

.w-richtext figure figcaption.w-richtext-figcaption-placeholder {
    opacity: .6
}

.w-richtext figure div {
    color: transparent;
    font-size: 0
}

.w-richtext figure.w-richtext-figure-type-image, .w-richtext figure[data-rt-type=image] {
    display: table
}

.w-richtext figure.w-richtext-figure-type-image>div, .w-richtext figure[data-rt-type=image]>div {
    display: inline-block
}

.w-richtext figure.w-richtext-figure-type-image>figcaption, .w-richtext figure[data-rt-type=image]>figcaption {
    caption-side: bottom;
    display: table-caption
}

.w-richtext figure.w-richtext-figure-type-video, .w-richtext figure[data-rt-type=video] {
    width: 60%;
    height: 0
}

.w-richtext figure.w-richtext-figure-type-video iframe, .w-richtext figure[data-rt-type=video] iframe {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0
}

.w-richtext figure.w-richtext-figure-type-video>div, .w-richtext figure[data-rt-type=video]>div {
    width: 100%
}

.w-richtext figure.w-richtext-align-center {
    clear: both;
    margin-left: auto;
    margin-right: auto
}

.w-richtext figure.w-richtext-align-center.w-richtext-figure-type-image>div, .w-richtext figure.w-richtext-align-center[data-rt-type=image]>div {
    max-width: 100%
}

.w-richtext figure.w-richtext-align-normal {
    clear: both
}

.w-richtext figure.w-richtext-align-fullwidth {
    width: 100%;
    max-width: 100%;
    text-align: center;
    clear: both;
    margin-left: auto;
    margin-right: auto;
    display: block
}

.w-richtext figure.w-richtext-align-fullwidth>div {
    padding-bottom: inherit;
    display: inline-block
}

.w-richtext figure.w-richtext-align-fullwidth>figcaption {
    display: block
}

.w-richtext figure.w-richtext-align-floatleft {
    float: left;
    clear: none;
    margin-right: 15px
}

.w-richtext figure.w-richtext-align-floatright {
    float: right;
    clear: none;
    margin-left: 15px
}

.w-nav {
    z-index: 1000;
    background: #ddd;
    position: relative
}

.w-nav:before, .w-nav:after {
    content: " ";
    grid-area: 1/1/2/2;
    display: table
}

.w-nav:after {
    clear: both
}

.w-nav-brand {
    float: left;
    color: #333;
    text-decoration: none;
    position: relative
}

.w-nav-link {
    vertical-align: top;
    color: #222;
    text-align: left;
    margin-left: auto;
    margin-right: auto;
    padding: 20px;
    text-decoration: none;
    display: inline-block;
    position: relative
}

.w-nav-link.w--current {
    color: #0082f3
}

.w-nav-menu {
    float: right;
    position: relative
}

[data-nav-menu-open] {
    text-align: center;
    min-width: 200px;
    background: #c8c8c8;
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    overflow: visible;
    display: block !important
}

.w--nav-link-open {
    display: block;
    position: relative
}

.w-nav-overlay {
    width: 100%;
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    overflow: hidden
}

.w-nav-overlay [data-nav-menu-open] {
    top: 0
}

.w-nav[data-animation=over-left] .w-nav-overlay {
    width: auto
}

.w-nav[data-animation=over-left] .w-nav-overlay, .w-nav[data-animation=over-left] [data-nav-menu-open] {
    z-index: 1;
    top: 0;
    right: auto
}

.w-nav[data-animation=over-right] .w-nav-overlay {
    width: auto
}

.w-nav[data-animation=over-right] .w-nav-overlay, .w-nav[data-animation=over-right] [data-nav-menu-open] {
    z-index: 1;
    top: 0;
    left: auto
}

.w-nav-button {
    float: right;
    cursor: pointer;
    -webkit-tap-highlight-color: transparent;
    tap-highlight-color: transparent;
    -webkit-user-select: none;
    -ms-user-select: none;
    user-select: none;
    padding: 18px;
    font-size: 24px;
    display: none;
    position: relative
}

.w-nav-button:focus {
    outline: 0
}

.w-nav-button.w--open {
    color: #fff;
    background-color: #c8c8c8
}

.w-nav[data-collapse=all] .w-nav-menu {
    display: none
}

.w-nav[data-collapse=all] .w-nav-button, .w--nav-dropdown-open, .w--nav-dropdown-toggle-open {
    display: block
}

.w--nav-dropdown-list-open {
    position: static
}

@media screen and (max-width:991px) {
    .w-nav[data-collapse=medium] .w-nav-menu {
        display: none
    }

    .w-nav[data-collapse=medium] .w-nav-button {
        display: block
    }
}

@media screen and (max-width:767px) {
    .w-nav[data-collapse=small] .w-nav-menu {
        display: none
    }

    .w-nav[data-collapse=small] .w-nav-button {
        display: block
    }

    .w-nav-brand {
        padding-left: 10px
    }
}

@media screen and (max-width:479px) {
    .w-nav[data-collapse=tiny] .w-nav-menu {
        display: none
    }

    .w-nav[data-collapse=tiny] .w-nav-button {
        display: block
    }
}

.w-tabs {
    position: relative
}

.w-tabs:before, .w-tabs:after {
    content: " ";
    grid-area: 1/1/2/2;
    display: table
}

.w-tabs:after {
    clear: both
}

.w-tab-menu {
    position: relative
}

.w-tab-link {
    vertical-align: top;
    text-align: left;
    cursor: pointer;
    color: #222;
    background-color: #ddd;
    padding: 9px 30px;
    text-decoration: none;
    display: inline-block;
    position: relative
}

.w-tab-link.w--current {
    background-color: #c8c8c8
}

.w-tab-link:focus {
    outline: 0
}

.w-tab-content {
    display: block;
    position: relative;
    overflow: hidden
}

.w-tab-pane {
    display: none;
    position: relative
}

.w--tab-active {
    display: block
}

@media screen and (max-width:479px) {
    .w-tab-link {
        display: block
    }
}

.w-ix-emptyfix:after {
    content: ""
}

@keyframes spin {
    0% {
        transform: rotate(0)
    }

    to {
        transform: rotate(360deg)
    }
}

.w-dyn-empty {
    background-color: #ddd;
    padding: 10px
}

.w-dyn-hide, .w-dyn-bind-empty, .w-condition-invisible {
    display: none !important
}

.wf-layout-layout {
    display: grid
}

:root {
    --purple-100: ghostwhite;
    --purple-200: #e8dafe;
    --purple-600-light: #8f51ff;
    --purple-1000-dark: #340e70;
    --grey-500: #949494;
    --grey-700: #676767;
    --black: black;
    --dashboardblue: #7978de;
    --purple-300: #d3bbfd;
    --sky: #1696f0;
    --wine: #e2154a;
    --grass: #7ce085;
    --candy: #cc50b6;
    --emerald: #53dbda;
    --peacock: #4e20d0;
    --lavender: #eeeefb
}

.w-layout-blockcontainer {
    max-width: 940px;
    margin-left: auto;
    margin-right: auto;
    display: block
}

.w-layout-vflex {
    flex-direction: column;
    align-items: flex-start;
    display: flex
}

.w-embed-youtubevideo {
    width: 100%;
    background-image: url(https://d3e54v103j8qbb.cloudfront.net/static/youtube-placeholder.2b05e7d68d.svg);
    background-position: 50%;
    background-size: cover;
    padding-bottom: 0;
    padding-left: 0;
    padding-right: 0;
    position: relative
}

.w-embed-youtubevideo:empty {
    min-height: 75px;
    padding-bottom: 56.25%
}

.w-layout-layout {
    grid-row-gap: 20px;
    grid-column-gap: 20px;
    grid-auto-columns: 1fr;
    justify-content: center;
    padding: 20px
}

.w-layout-cell {
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    display: flex
}

@media screen and (max-width:991px) {
    .w-layout-blockcontainer {
        max-width: 728px
    }
}

@media screen and (max-width:767px) {
    .w-layout-blockcontainer {
        max-width: none
    }
}

h1 {
    margin-top: 20px;
    margin-bottom: 10px;
    font-size: 38px;
    font-weight: 700;
    line-height: 44px
}

.grid-2-col {
    width: 100%;
    height: auto;
    color: #2e2a33;
    background-color: #fff;
    margin-top: 120px;
    padding: 0 48px 40px;
    font-family: Mulish, sans-serif;
    font-size: 18px;
    line-height: 28px;
    display: block;
    overflow: hidden
}

.grid-2-col.background-purple100 {
    max-width: none;
    min-height: 100svh;
    background-color: var(--purple-100)
}

.grid-2-col.background-purple100.pricing {
    padding-top: 42px
}

.grid-2-col.background-gradient-light {
    min-height: 100vh;
    background-image: linear-gradient(204deg, #fff, #e2e7ff 50%, #f4cbf8);
    justify-content: center;
    display: flex;
    overflow: hidden
}

.grid-2-col.background-gradient-dark {
    min-height: 100svh;
    background-image: linear-gradient(204deg, #efd6f5, #c2d1ff 50%, #d9eafb);
    justify-content: center;
    display: flex;
    overflow: hidden
}

.grid-2-col.no-min-height {
    min-height: auto;
    flex-direction: column;
    align-items: center;
    display: flex
}

.grid-2-col.careers-hero {
    max-width: none;
    min-height: auto;
    background-image: none;
    margin-bottom: 0;
    padding-top: 170px;
    padding-bottom: 220px
}

.grid-2-col.careers-hero.background_purple-100 {
    width: 100%;
    max-width: none;
    background-color: #f8f8ff;
    background-image: none;
    justify-content: center;
    display: flex;
    overflow: visible
}

.grid-2-col.careers-hero.grandient {
    background-image: linear-gradient(34deg, var(--purple-200), #e9f7ff 100%, white)
}

.grid-2-col.careers-hero.purple-100, .grid-2-col.background-purple10 {
    background-color: var(--purple-100)
}

.grid-2-col.feature {
    max-width: none;
    min-height: auto;
    margin-top: 0;
    padding: 40px
}

.grid-2-col.feature.background_purple-100 {
    width: 100%;
    max-width: none;
    background-color: #f8f8ff;
    justify-content: center;
    display: flex;
    overflow: visible
}

.grid-2-col.feature.grandient {
    background-image: linear-gradient(34deg, var(--purple-200), #e9f7ff 100%, white)
}

.grid-2-col.feature.last {
    padding-bottom: 80px
}

.grid-2-col.pricing {
    max-width: none
}

.grid-2-col.pricing.compare {
    padding-top: 30px
}

.grid-2-col.mt-80 {
    padding-top: 80px
}

.content {
    max-width: 1200px;
    grid-column-gap: 0px;
    grid-row-gap: 0px;
    flex-flow: column;
    justify-content: center;
    align-items: flex-start;
    font-style: normal;
    display: flex
}

.content.flush-left {
    flex-direction: column;
    align-items: center
}

.content.flush-left.hero {
    flex-direction: row;
    justify-content: space-between;
    align-items: flex-start;
    margin-top: 20px;
    padding-bottom: 200px
}

.content.cta {
    width: 425px;
    justify-content: center
}

.content.footer {
    grid-column-gap: 18px;
    grid-row-gap: 18px;
    grid-template-rows: auto;
    grid-template-columns: 1fr .5fr minmax(300px, .75fr) .5fr;
    grid-auto-columns: 1fr;
    grid-auto-flow: row;
    align-content: start;
    justify-content: start;
    align-items: start;
    justify-items: start;
    display: grid
}

.content.informal {
    flex-direction: column;
    align-items: center
}

.content.side-image {
    grid-column-gap: 0px;
    grid-row-gap: 0px;
    flex-direction: row;
    justify-content: flex-start
}

.content.kpis {
    grid-column-gap: 60px;
    grid-row-gap: 60px;
    flex-direction: column
}

.content.quote.infographic {
    justify-content: center;
    align-items: center
}

.content.feature {
    background-color: rgba(226, 21, 74, .15);
    border-radius: 24px;
    flex-direction: row;
    padding: 60px
}

.content.feature.wine {
    background-color: rgba(226, 21, 74, .05);
    align-items: center
}

.content.feature.sky {
    grid-column-gap: 0px;
    grid-row-gap: 0px;
    background-color: rgba(22, 150, 240, .05);
    align-items: center
}

.content.feature.grass {
    background-color: rgba(124, 224, 133, .05);
    align-items: center
}

.content.feature.candy {
    background-color: rgba(204, 80, 182, .05);
    align-items: center
}

.content.feature.candy.outline.flip {
    flex-direction: row-reverse
}

.content.feature.emerald {
    background-color: rgba(83, 219, 218, .05);
    align-items: center
}

.content.feature.peacock {
    background-color: rgba(78, 32, 208, .05);
    justify-content: space-between;
    align-items: center
}

.content.feature.outline {
    border: 3px solid var(--purple-100);
    background-color: #fff;
    padding-top: 120px;
    padding-bottom: 120px
}

.content.feature.outline.flip {
    flex-direction: row-reverse
}

.content.infographic {
    flex-direction: row;
    justify-content: flex-start;
    align-items: flex-end
}

.content.infographic.swap {
    flex-direction: row-reverse
}

.content.pricing {
    align-items: center
}

.panel-text {
    max-width: 940px;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    padding-bottom: 0;
    display: flex
}

.panel-text.centered {
    width: 65%;
    max-width: 940px;
    grid-column-gap: 20px;
    grid-row-gap: 20px;
    text-align: center;
    align-self: center;
    align-items: center;
    padding-bottom: 0;
    padding-right: 20px
}

.panel-text.centered.informal {
    padding-right: 0
}

.panel-text.centered.compare, .panel-text.centered.pricing {
    margin-bottom: 60px
}

.panel-text.centered.vp {
    padding-right: 0
}

.panel-text.side-by-side {
    max-width: 48%;
    margin-left: 0;
    margin-right: 0;
    padding-top: 70px
}

.panel-text.left {
    width: 50%;
    grid-column-gap: 10px;
    grid-row-gap: 10px;
    justify-content: flex-start;
    align-items: flex-start
}

.panel-text.left.inforgraphic {
    width: 55%;
    align-self: flex-end
}

.panel-text.left.cloud {
    width: 60%;
    background-image: url(https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64ad709444b2c666b969a855_Cloud.svg);
    background-position: 50%;
    background-repeat: no-repeat;
    background-size: contain;
    padding: 80px 60px
}

.panel-text.left.center {
    width: 100%;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center
}

.panel-text.git {
    max-width: 980px
}

.panel-text.kpis {
    width: 65%;
    grid-column-gap: 20px;
    grid-row-gap: 20px;
    text-align: center;
    align-self: center;
    align-items: center;
    padding-bottom: 0;
    padding-right: 0
}

.panel-text.feature {
    width: 60%;
    grid-column-gap: 10px;
    grid-row-gap: 10px;
    flex-direction: column;
    justify-content: flex-start;
    align-self: flex-start;
    align-items: flex-start;
    padding-top: 0
}

.panel-text.feature.flip {
    padding-left: 40px
}

.panel-text.feature.flip.outline {
    max-width: 980px
}

.panel-text.feature.outline {
    max-width: 980px;
    padding-right: 40px
}

.utility-page-wrap {
    width: 100vw;
    height: 100vh;
    max-height: 100%;
    max-width: 100%;
    justify-content: center;
    align-items: center;
    display: flex
}

.utility-page-content {
    width: 260px;
    text-align: center;
    flex-direction: column;
    display: flex
}

.utility-page-form {
    flex-direction: column;
    align-items: stretch;
    display: flex
}

.body {
    flex-direction: column;
    align-items: center;
    margin-left: auto;
    margin-right: auto;
    font-family: Mulish, sans-serif;
    display: flex;
    overflow-x:hidden !important; 
}

.solid-button {
    height: 42px;
    background-color: var(--purple-600-light);
    color: #fff;
    text-align: center;
    cursor: pointer;
    border-radius: 21px;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 0 20px;
    font-size: 16px;
    font-weight: 800;
    line-height: 16px;
    display: flex
}

.solid-button:hover {
    background-color: var(--purple-1000-dark)
}

.solid-button:active {
    background-color: rgba(143, 81, 255, .5)
}

.solid-button.content {
    z-index: 9;
    margin-top: 16px;
    position: relative
}

.solid-button.content:hover {
    background-color: var(--purple-1000-dark)
}

.solid-button.content:active {
    background-color: rgba(143, 81, 255, .5)
}

.solid-button.form-button {
    margin-top: 40px
}

.top-navigation-wrapper {
    z-index: 11;
    width: 100vw;
    height: 90px;
    grid-column-gap: 16px;
    grid-row-gap: 16px;
    -webkit-backdrop-filter: blur(15px);
    backdrop-filter: blur(15px);
    background-color: rgba(255, 255, 255, .01);
    flex-direction: row;
    grid-template-rows: auto auto;
    grid-template-columns: 1fr 1fr;
    grid-auto-columns: 1fr;
    justify-content: center;
    align-items: center;
    font-family: Mulish, sans-serif;
    display: flex;
    position: fixed;
    top: 0%;
    bottom: auto;
    left: 0%;
    right: 0%
}

.navbar-content {
    width: 100%;
    height: 50px;
    max-width: 1200px;
    grid-row-gap: 50px;
    object-fit: fill;
    flex-flow: row;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
    display: flex;
    position: relative;
    overflow: visible
}

.link-block {
    width: auto;
    height: 100%;
    font-family: Mulish, sans-serif;
    text-decoration: none;
    display: block;
    position: relative
}

.link-block:hover {
    color: var(--purple-600-light)
}

.product-menu {
    z-index: 2;
    width: 100%;
    background-color: #fff;
    margin-top: -20px;
    padding-top: 20px;
    display: block;
    position: relative;
    box-shadow: 0 0 10px rgba(0, 0, 0, .1)
}

.menu-content {
    max-width: 1200px;
    justify-content: flex-start;
    align-items: flex-start;
    margin-top: 0;
    margin-bottom: 0;
    padding-top: 50px;
    padding-bottom: 50px;
    display: flex;
    position: relative
}

.menu-column {
    width: 100%;
    flex-direction: column;
    padding-right: 40px;
    display: flex
}

.menu-column.highlight {
    width: 100%;
    max-width: 350px;
    min-width: auto;
    background-color: var(--purple-100);
    width: 100%;
    max-width: 350px;
    min-width: auto;
    background-color: #f8f8ff;
    border-radius: 14px;
    padding: 0
}

.menu-column-title {
    height: 20px;
    color: var(--grey-500);
    margin-bottom: 28px;
    font-family: Mulish, sans-serif;
    font-size: 17px;
    font-weight: 500
}

.menu-column-items {
    grid-column-gap: 18px;
    grid-row-gap: 18px;
    flex-direction: column;
    align-items: flex-start;
    padding: 0;
    display: flex
}

.menu-column-items.highlight {
    max-width: 381.82px;
    padding: 26px
}

.button-text {
    color: var(--purple-1000-dark);
    font-family: Mulish, sans-serif;
    font-size: 17px;
    font-weight: 400;
    line-height: 24px
}

.button-icon {
    width: 16px;
    max-width: 100%;
    padding-top: 5px;
    position: relative
}

.menu-button-wrapper {
    max-width: 300px;
    grid-column-gap: 8px;
    grid-row-gap: 8px;
    align-items: flex-start;
    text-decoration: none;
    display: flex
}

.two-line-text-wrapper {
    max-width: none
}

.button-description {
    max-width: none;
    color: var(--grey-700);
    font-family: Mulish, sans-serif;
    font-size: 14px;
    font-weight: 400;
    line-height: 18px
}

.home-link-block {
    height: 100%;
    position: relative
}

.image-2 {
    height: 50px
}

.menu-sections {
    grid-column-gap: 50px;
    grid-row-gap: 50px;
    align-items: center;
    display: flex
}

.menu-cta {
    height: 50px;
    grid-column-gap: 30px;
    grid-row-gap: 30px;
    align-items: center;
    display: flex
}

.section-item-wrapper {
    height: 100%;
    grid-column-gap: 8px;
    grid-row-gap: 8px;
    align-items: center;
    display: flex
}

.section-text {
    color: var(--black);
    font-size: 16px;
    font-weight: 600;
    display: block
}

.section-text:hover {
    color: var(--purple-600-light)
}

.image-3 {
    padding-top: 4px;
    padding-bottom: 0
}

.why-menu {
    z-index: 2;
    width: 100%;
    background-color: #fff;
    margin-top: 0;
    padding-top: 20px;
    display: block;
    position: relative;
    box-shadow: 0 0 10px rgba(0, 0, 0, .1)
}

.product-menu-wrapper {
    z-index: 2;
    height: auto;
    grid-column-gap: 50px;
    grid-row-gap: 50px;
    background-color: transparent;
    flex-direction: column;
    flex: 1;
    grid-template-rows: auto auto;
    grid-template-columns: 1fr 1fr;
    grid-auto-columns: 1fr;
    padding-bottom: 20px;
    display: flex;
    position: absolute;
    top: 90px;
    bottom: auto;
    left: 0;
    right: 0;
    overflow: hidden
}

.product-menu-wrapper.menu_dropdown_content {
    z-index: 1;
    display: none
}

.menu-quote-wrapper {
    max-width: 300px;
    grid-column-gap: 2px;
    grid-row-gap: 2px;
    align-items: flex-start;
    text-decoration: none;
    display: flex
}

.quotemark-text {
    color: var(--purple-1000-dark);
    padding-top: 1px;
    font-family: Mulish, sans-serif;
    font-size: 24px;
    font-weight: 300;
    line-height: 24px
}

.quote-text {
    max-width: none;
    color: var(--purple-1000-dark);
    padding-bottom: 6px;
    font-family: Mulish, sans-serif;
    font-size: 17px;
    font-weight: 400;
    line-height: 24px
}

.quote-description {
    color: var(--grey-700);
    font-family: Mulish, sans-serif;
    font-size: 14px;
    font-weight: 400;
    line-height: 18px
}

.why-menu-wrapper {
    z-index: 2;
    height: auto;
    grid-column-gap: 50px;
    grid-row-gap: 50px;
    flex-direction: column;
    align-items: flex-start;
    padding-bottom: 20px;
    display: flex;
    position: absolute;
    top: 90px;
    bottom: auto;
    left: 0;
    right: 0;
    overflow: hidden
}

.why-menu-wrapper.menu_dropdown_content {
    z-index: 1;
    display: none;
    overflow: hidden
}

.ticker {
    width: auto;
    height: 250px;
    max-width: 100%;
    flex-wrap: nowrap;
    flex: 1;
    margin-left: auto;
    margin-right: auto;
    display: flex;
    position: relative;
    bottom: 0;
    overflow: scroll
}

.ticker-wrapper {
    width: 100%;
    display: flex;
    position: absolute;
    bottom: 60px;
    left: 0;
    right: 0;
    overflow: hidden
}

.ticker-rollover {
    width: 25%;
    height: 40px;
    position: absolute;
    bottom: 0
}

.ticker-overlay {
    width: 100%;
    display: none;
    position: relative;
    bottom: 0
}

.panel-heading {
    width: auto;
    max-width: 100%;
    color: var(--black);
    align-self: center;
    margin-top: 0;
    margin-bottom: 16px;
    font-family: Mulish, sans-serif;
    font-size: 60px;
    font-weight: 800;
    line-height: 70px;
    position: static;
}

.panel-heading-center {
    width: auto;
    max-width: 100%;
    color: var(--black);
    align-self: center;
    margin-top: 0;
    margin-bottom: 16px;
    font-family: Mulish, sans-serif;
    font-size: 60px;
    font-weight: 800;
    line-height: 70px;
    position: static;
    text-align: center;
}
.panel-heading.informal {
    font-family: Mulish, sans-serif;
    font-weight: 700
}

.panel-heading.pricing {
    width: 120%;
    max-width: 120%
}

.panel-heading.heading-long {
    min-width: 900px
}

.panel-heading.white, .panel-heading.white-text {
    color: #fff
}

.hero-image {
    width: 500.5px;
    height: 370.992px;
    object-fit: cover;
    border-radius: 20px;
    align-self: center;
    display: none;
    position: relative;
    top: 0%;
    bottom: auto;
    left: auto;
    right: 0
}

.image-4 {
    object-fit: scale-down;
    position: absolute;
    top: auto;
    bottom: -42%;
    left: auto;
    right: -11%
}

.image-5 {
    object-fit: contain;
    position: absolute;
    top: auto;
    bottom: -20%;
    left: -20%;
    right: auto
}

.image-6 {
    object-fit: scale-down;
    position: absolute;
    top: 10%;
    bottom: auto;
    left: -11%;
    right: auto
}

.centeral-image {
    width: 600px;
    height: 450px;
    flex: 0 auto;
    position: relative;
    top: 0;
    left: auto;
    right: 0
}

.image-7 {
    position: absolute;
    top: auto;
    bottom: -15%;
    left: 14%;
    right: auto
}

.image-8 {
    position: absolute;
    top: auto;
    bottom: -45%;
    left: 42%;
    right: auto
}

.image-9 {
    position: absolute;
    top: auto;
    bottom: 33%;
    left: -15%;
    right: auto
}

.image-10 {
    position: absolute;
    top: auto;
    bottom: 29%;
    left: auto;
    right: -14%
}

.image-11 {
    position: absolute;
    top: auto;
    bottom: -9%;
    left: -36%;
    right: auto
}

.panel-paragraph {
    max-width: 570px;
    text-align: left;
    align-self: center;
    margin-bottom: 8px;
    position: static;
    overflow: visible
}

.panel-paragraph.git {
    text-align: center
}

.panel-paragraph.left {
    text-align: left;
    align-self: flex-start
}

.panel-paragraph.left.center {
    text-align: center;
    align-self: center;
    position: relative
}

.panel-paragraph.center {
    text-align: center
}

.panel-paragraph.center.cloud {
    color: var(--purple-1000-dark);
    font-weight: 700
}

.panel-paragraph.center.white-text {
    color: #fff;
    font-size: 24px;
    line-height: 30px
}

.panel-visual-dashboard {
    width: 100%;
    min-height: 250px;
    grid-column-gap: 44px;
    grid-row-gap: 44px;
    justify-content: flex-start;
    align-items: flex-end;
    margin-top: 60px;
    display: flex;
    position: relative;
    top: 0;
    left: 0;
    right: 0
}

.panel-visual-dashboard.cards {
    justify-content: space-between
}

.panel-visual-dashboard.side-by-side {
    width: auto;
    max-width: 48%;
    justify-content: flex-end;
    margin-top: 0;
    margin-left: 0;
    margin-right: 0
}

.panel-visual-dashboard.logos {
    min-height: 100px;
    margin-top: 0
}

.panel-visual-dashboard.tight {
    grid-column-gap: 0px;
    grid-row-gap: 0px
}

.brand-growth {
    position: absolute;
    top: 0%;
    bottom: auto;
    left: 0%;
    right: 0%
}

.brand-growth-line {
    position: relative;
    top: 10px;
    bottom: auto;
    left: 0%;
    right: 0%
}

.dashboard-dating {
    position: relative;
    top: 0%;
    bottom: auto;
    left: 0%;
    right: 0%
}

.dashboard-panels {
    max-width: 125%;
    margin-top: 10px;
    overflow: visible
}

.panel-info-card {
    width: 24%;
    height: 348px;
    max-width: 280px;
    background-color: #fff;
    border-radius: 14px;
    padding: 40px 24px
}

.info-card-title {
    color: #9450ff;
    font-size: 40px;
    font-weight: 800;
    line-height: 50px
}

.info-card-description {
    margin-top: 24px
}

.info-card-subtitle {
    color: #141414;
    font-size: 20px;
    font-weight: 800;
    line-height: 26px
}

.customer-logos {
    max-width: 200%;
    margin-top: 100px;
    overflow: visible
}

.brand-bites {
    width: 100vw;
    max-width: none;
    margin-top: auto;
    overflow: visible
}

.footer-heading {
    width: auto;
    max-width: 100%;
    color: var(--black);
    margin-top: 0;
    margin-bottom: 16px;
    font-family: Mulish, sans-serif;
    font-size: 18px;
    font-weight: 800;
    line-height: 32px;
    position: static
}

.footer-link {
    color: #1a1413;
    line-height: 32px;
    text-decoration: none
}

.footer-link:hover {
    color: var(--purple-600-light)
}

.footer-link:active {
    color: var(--purple-1000-dark);
    -webkit-text-stroke-color: var(--purple-1000-dark)
}

.logo-footer {
    width: 130px
}

.footer-links {
    width: 100%;
    grid-column-gap: 50px;
    justify-content: flex-end;
    align-items: flex-start;
    display: flex
}

.footer-legal-social {
    width: 100%;
    max-width: 1200px;
    justify-content: space-between;
    align-items: center;
    margin-top: 120px;
    display: flex
}

.legal-block {
    font-size: 12px;
    line-height: 16px
}

.text-block {
    margin-top: 40px
}

.usp1a {
    width: 100%;
    height: 100vh;
    max-width: 1440px;
    grid-column-gap: 44px;
    grid-row-gap: 44px;
    background-color: #fff;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    padding: 60px 120px;
    display: flex;
    position: relative
}

.header-block {
    grid-column-gap: 16px;
    grid-row-gap: 16px;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;
    display: flex
}

.headline {
    color: #000;
    text-align: center;
    font-family: Mulish, sans-serif;
    font-size: 60px;
    font-weight: 800;
    line-height: 70px
}

.subline {
    color: #2e2a33;
    text-align: center;
    font-family: Mulish, sans-serif;
    font-size: 18px;
    font-weight: 400;
    line-height: 28px
}

.story-block {
    grid-column-gap: 44px;
    grid-row-gap: 44px;
    flex: 0 auto;
    justify-content: flex-start;
    align-items: flex-start;
    display: flex;
    position: -webkit-sticky;
    position: sticky
}

.images {
    grid-column-gap: 20px;
    grid-row-gap: 20px;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;
    display: flex
}

.vectors-wrapper {
    width: 894px;
    min-height: 600px;
    grid-column-gap: 0px;
    grid-row-gap: 0px;
    object-fit: cover;
    flex: 0 auto;
    justify-content: center;
    align-items: center;
    display: flex
}

.pages {
    grid-column-gap: 12px;
    grid-row-gap: 12px;
    flex: 0 auto;
    justify-content: center;
    align-items: flex-start;
    display: flex
}

.vectors-wrapper-2 {
    width: 16px;
    height: 16px;
    grid-column-gap: 0px;
    grid-row-gap: 0px;
    object-fit: cover;
    justify-content: center;
    align-items: center;
    display: flex
}

.text {
    grid-column-gap: 10px;
    grid-row-gap: 10px;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    padding-top: 162px;
    display: flex
}

.description {
    font-weight: 400;
    display: none
}

.section {
    width: 100%;
    grid-column-gap: 0px;
    grid-row-gap: 0px;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;
    padding-top: 64px;
    padding-bottom: 64px;
    display: flex
}

.container {
    width: 100%;
    max-width: 1200px;
    grid-column-gap: 0px;
    grid-row-gap: 0px;
    background-color: #f8f8f8;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    padding: 24px;
    display: flex
}

.new-page {
    width: 100%;
    grid-column-gap: 0px;
    grid-row-gap: 0px;
    background-color: #fff;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;
    display: flex
}

.description-0 {
    color: #2e2a33;
    font-family: Mulish, sans-serif;
    font-size: 24px;
    font-weight: 800;
    line-height: 32px
}

.description-1 {
    color: #2e2a33;
    font-family: Mulish, sans-serif;
    font-size: 18px;
    font-weight: 400;
    line-height: 28px
}

.visualframe {
    width: 100%;
    height: 599.965px;
    max-width: 894px;
    grid-column-gap: 20px;
    grid-row-gap: 20px;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;
    display: flex
}

.screen-frame {
    width: 894px;
    height: 564px;
    min-width: 894px;
    grid-column-gap: 0px;
    grid-row-gap: 0px;
    object-fit: cover;
    flex: 0 auto;
    justify-content: center;
    align-items: center;
    display: block;
    position: relative
}

.vectors-wrapper-4 {
    width: 16px;
    height: 16px;
    grid-column-gap: 0px;
    grid-row-gap: 0px;
    object-fit: cover;
    justify-content: center;
    align-items: center;
    display: flex
}

.contentwrapper {
    width: 100%;
    height: 483px;
    max-width: 857px;
    grid-column-gap: 10px;
    grid-row-gap: 10px;
    border: 0 #000;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    margin-top: 62px;
    margin-left: 18px;
    padding-top: 100px;
    padding-left: 75px;
    display: block;
    position: absolute;
    top: 0%;
    bottom: 0%;
    left: 0%;
    right: 0%
}

.tabcontent {
    grid-column-gap: 100px;
    grid-row-gap: 100px;
    flex: 0 auto;
    justify-content: flex-start;
    align-items: flex-start;
    display: flex
}

.audiencescreens {
    grid-column-gap: 0px;
    grid-row-gap: 0px;
    object-fit: cover;
    flex: 0 auto;
    justify-content: center;
    align-items: center;
    display: flex
}

.purchasedrivers {
    grid-column-gap: 17px;
    grid-row-gap: 17px;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    display: flex
}

.purchasedrivers-2 {
    grid-column-gap: 17px;
    grid-row-gap: 17px;
    flex: 0 auto;
    justify-content: flex-start;
    align-items: flex-start;
    display: flex
}

.vp_visualframe {
    width: 77%;
    position: relative
}

.image-12 {
    display: block;
    position: relative
}

.div-block {
    width: 100%
}

.div-block-2, .div-block-3 {
    width: 100px
}

.div-block-4 {
    width: 100%
}

.div-block-5 {
    width: 1551.43px
}

.div-block-6 {
    height: 485px;
    overflow: hidden
}

.charts {
    width: 1551.43px;
    height: 746.21px;
    max-width: none;
    position: absolute;
    top: 88px;
    left: 63px
}

.image-13 {
    position: absolute;
    top: 20px;
    left: 73px
}

.pageindicator {
    width: 16px;
    height: 16px;
    border: 1px solid var(--dashboardblue);
    cursor: pointer;
    border-radius: 8px
}

.pageindicator.active {
    background-color: var(--dashboardblue)
}

.wrapper {
    z-index: 9;
    width: auto;
    max-width: 100vw;
    flex-flow: row;
    flex: 0 auto;
    align-items: center;
    margin-top: -320px;
    display: flex;
    position: relative;
    bottom: 0;
    overflow: scroll;
}
.trust-by-heading{
    position: absolute;
    left: 40px;
}
.tooltip {
    flex-direction: row;
    flex: 0 auto;
    margin-left: 40px;
    margin-right: 40px;
    padding-left: 20px;
    padding-right: 20px;
    font-family: Mulish, sans-serif;
    display: block;
    overflow: visible
}

.tooltip.hide {
    display: none
}

.logo {
    width: 140px;
    align-items: center;
    display: flex;
    position: relative;
    top: 200px;
    bottom: auto
}

.logo.sephora {
    margin-top: 10px
}

.text-block-2 {
    color: #8c8c8b;
    align-self: center;
    font-size: 16px
}

.ticker-content {
    flex: 0 auto;
    margin-left: 30px;
    margin-right: 30px
}

.tooltiptext {
    z-index: auto;
    width: 320px;
    height: 190px;
    background-color: #240c53;
    border-radius: 3px;
    padding-bottom: 10px;
    padding-left: 10px;
    padding-right: 10px;
    font-family: Mulish, sans-serif;
    display: block;
    position: relative;
    top: 0;
    left: -18%;
    overflow: visible
}

.tooltiptext.slnt, .tooltiptext.hide {
    display: none
}

.tooltip-list-item {
    justify-content: space-between;
    display: flex
}

.div-block-7 {
    display: flex
}

.heading {
    color: #e2e2e2;
    margin-top: 10px;
    margin-bottom: -9px;
    font-family: Mulish, sans-serif;
    font-size: 16px
}

.text-block-3 {
    color: #8c8c8c;
    padding-bottom: 20px;
    font-family: Mulish, sans-serif;
    font-size: 12px
}

.text-block-4, .text-block-5, .text-block-6, .text-block-7, .text-block-8, .text-block-9, .text-block-10, .text-block-11 {
    color: #e2e2e2;
    font-family: Mulish, sans-serif;
    font-size: 12px
}

.text-block-12 {
    color: #34c759;
    padding-left: 5px;
    padding-right: 5px;
    font-family: Mulish, sans-serif;
    font-size: 12px
}

.image-14 {
    padding-left: 20px;
    padding-right: 5px
}

.text-block-13 {
    padding-right: 5px;
    font-size: 16px
}

.slider {
    display: flex
}

.vp_captionframe {
    width: 262px;
    height: auto;
    grid-column-gap: 44px;
    grid-row-gap: 44px;
    align-self: flex-end;
    padding-bottom: 20px
}

.heading-2 {
    font-weight: 800;
    line-height: 28px
}

.heading-2.ranking {
    width: auto;
    text-align: left;
    font-size: 30px;
    line-height: 35px
}

.vp1_as2 {
    grid-column-gap: 11px;
    grid-row-gap: 11px;
    cursor: pointer;
    align-items: center;
    display: flex
}

.vp1_as2.hide {
    display: none
}

.alsosee {
    color: var(--dashboardblue);
    font-weight: 700;
    line-height: 22px;
    text-decoration: none
}

.link-block-2 {
    text-decoration: none
}

.alsosee-wrapper {
    grid-column-gap: 22px;
    grid-row-gap: 22px
}

.div-block-8 {
    height: 50px
}

.screendotsframe {
    height: 50px;
    grid-column-gap: 12px;
    grid-row-gap: 12px;
    justify-content: center;
    align-items: flex-end;
    display: flex
}

.dot-2 {
    width: 16px;
    height: 16px;
    border: 1.5px solid var(--dashboardblue);
    cursor: pointer;
    background-color: #fff;
    border-radius: 8px
}

.dot-2.active {
    background-color: var(--dashboardblue);
    cursor: auto
}

.screenframe {
    width: 96.5%;
    height: 79.5%;
    display: flex;
    position: absolute;
    top: 0%;
    bottom: auto;
    left: 0%;
    right: auto;
    overflow: hidden
}

.image-15 {
    position: absolute;
    top: 80px;
    bottom: auto;
    left: 90px;
    right: auto
}

.image-16 {
    width: 356.5px;
    height: 600.81px;
    max-width: none
}

.mod-1_p3 {
    width: 712.22px;
    height: 429.52px;
    object-fit: cover;
    margin-top: -9px;
    display: none
}

.mod-1_p3.hidden {
    display: none
}

.dashboard-modules-wrapper {
    width: 82.5567%;
    grid-column-gap: 0px;
    grid-row-gap: 0px;
    flex-direction: column;
    align-items: flex-start;
    margin-top: 98px;
    margin-left: 70px;
    padding-top: 10px;
    display: flex;
    position: relative
}

.vp1_s1 {
    object-fit: contain;
    display: block
}

.vp1_s1.current {
    display: block
}

.div-block-10 {
    z-index: 10;
    width: 400px;
    height: 157px;
    background-color: var(--dashboardblue);
    position: absolute;
    top: 0%;
    bottom: auto;
    left: 0%;
    right: auto
}

.vp1_t2, .vp1_t3 {
    display: none
}

.vp1_as3 {
    grid-column-gap: 11px;
    grid-row-gap: 11px;
    cursor: pointer;
    align-items: center;
    display: flex
}

.vp1_as3.hide {
    display: none
}

.vp1_as1 {
    grid-column-gap: 11px;
    grid-row-gap: 11px;
    cursor: pointer;
    align-items: center;
    display: none
}

.vp1_as1.hide {
    display: none
}

.mod-1_p2 {
    width: 712.22px;
    height: 429.52px;
    object-fit: cover;
    margin-top: -9px;
    display: block
}

.mod-1_p2.hidden {
    display: none
}

.mod-1_p4 {
    width: 712.22px;
    height: 429.52px;
    object-fit: cover;
    margin-top: -9px;
    display: none
}

.mod-1_p4.hidden {
    display: none
}

.mod-1_p1 {
    width: 712.22px;
    height: 429.52px;
    object-fit: cover;
    margin-top: -9px;
    display: block
}

.mod-1_p1.hidden {
    display: none
}

.content-panel-factoids {
    width: 100%;
    height: auto;
    min-height: 100svh;
    color: #2e2a33;
    background-color: #fff;
    margin-top: auto;
    padding: 80px 48px;
    font-family: Mulish, sans-serif;
    font-size: 18px;
    line-height: 28px;
    display: block;
    overflow: hidden
}

.content-panel-factoids.background-purple100 {
    min-height: 100svh;
    background-color: #f8f8ff
}

.content-panel-factoids.background-purple100.no-min-height {
    text-align: center;
    flex-direction: column;
    justify-content: center
}

.content-panel-factoids.background-gradient-light {
    min-height: 100vh;
    background-image: linear-gradient(204deg, #fff, #e2e7ff 50%, #f4cbf8);
    justify-content: center;
    display: flex;
    overflow: hidden
}

.content-panel-factoids.background-gradient-dark {
    min-height: 100svh;
    background-image: linear-gradient(204deg, #efd6f5, #c2d1ff 50%, #d9eafb);
    justify-content: center;
    display: flex;
    overflow: hidden
}

.content-panel-factoids.no-min-height {
    min-height: auto;
    flex-direction: column;
    align-items: center;
    display: flex
}

.content-panel-brands {
    width: 100%;
    height: auto;
    min-height: 100svh;
    color: #2e2a33;
    background-color: #fff;
    margin-top: auto;
    padding: 80px 48px;
    font-family: Mulish, sans-serif;
    font-size: 18px;
    line-height: 28px;
    display: block;
    overflow: hidden
}

.content-panel-brands.background-purple100 {
    min-height: 100svh;
    background-color: #f8f8ff
}

.content-panel-brands.background-gradient-light {
    min-height: 100vh;
    background-image: linear-gradient(204deg, #fff, #e2e7ff 50%, #f4cbf8);
    justify-content: center;
    display: flex;
    overflow: hidden
}

.content-panel-brands.background-gradient-dark {
    min-height: 100svh;
    background-image: linear-gradient(204deg, #efd6f5, #c2d1ff 50%, #d9eafb);
    justify-content: center;
    display: flex;
    overflow: hidden
}

.content-panel-brands.no-min-height {
    min-height: auto;
    flex-direction: column;
    align-items: center;
    display: flex
}

.content-panel-bites {
    width: 100%;
    height: auto;
    min-height: 100svh;
    color: #2e2a33;
    background-color: #fff;
    margin-top: auto;
    padding: 80px 48px;
    font-family: Mulish, sans-serif;
    font-size: 18px;
    line-height: 28px;
    display: block;
    overflow: hidden
}

.content-panel-bites.background-purple100 {
    min-height: 100svh;
    background-color: #f8f8ff
}

.content-panel-bites.background-gradient-light {
    min-height: 100vh;
    background-image: linear-gradient(204deg, #fff, #e2e7ff 50%, #f4cbf8);
    justify-content: center;
    display: flex;
    overflow: hidden
}

.content-panel-bites.background-gradient-dark {
    min-height: 100svh;
    background-image: linear-gradient(204deg, #efd6f5, #c2d1ff 50%, #d9eafb);
    justify-content: center;
    display: flex;
    overflow: hidden
}

.content-panel-bites.no-min-height {
    min-height: auto;
    flex-direction: column;
    align-items: center;
    display: flex
}

.content-panel-getintouch {
    width: 100%;
    height: auto;
    min-height: 100svh;
    color: #2e2a33;
    background-color: #fff;
    margin-top: auto;
    padding: 80px 48px;
    font-family: Mulish, sans-serif;
    font-size: 18px;
    line-height: 28px;
    display: block;
    overflow: hidden
}

.content-panel-getintouch.background-purple100 {
    min-height: 100svh;
    background-color: #f8f8ff
}

.content-panel-getintouch.background-gradient-light {
    min-height: 100vh;
    background-image: linear-gradient(204deg, #fff, #e2e7ff 50%, #f4cbf8);
    justify-content: center;
    display: flex;
    overflow: hidden
}

.content-panel-getintouch.background-gradient-dark {
    min-height: auto;
    background-image: linear-gradient(204deg, #efd6f5, #c2d1ff 50%, #d9eafb);
    justify-content: center;
    align-items: center;
    padding-top: 160px;
    padding-bottom: 160px;
    display: flex
}

.content-panel-getintouch.no-min-height {
    min-height: auto;
    flex-direction: column;
    align-items: center;
    display: flex
}

.content-panel-footer {
    width: 100%;
    height: auto;
    min-height: 100svh;
    color: #2e2a33;
    background-color: #fff;
    margin-top: auto;
    padding: 80px 48px;
    font-family: Mulish, sans-serif;
    font-size: 18px;
    line-height: 28px;
    display: block;
    overflow: hidden
}

.content-panel-footer.background-purple100 {
    min-height: 100svh;
    background-color: #f8f8ff
}

.content-panel-footer.background-gradient-light {
    min-height: 100vh;
    background-image: linear-gradient(204deg, #fff, #e2e7ff 50%, #f4cbf8);
    justify-content: center;
    display: flex;
    overflow: hidden
}

.content-panel-footer.background-gradient-dark {
    min-height: 100svh;
    background-image: linear-gradient(204deg, #efd6f5, #c2d1ff 50%, #d9eafb);
    justify-content: center;
    display: flex;
    overflow: hidden
}

.content-panel-footer.no-min-height {
    min-height: auto;
    flex-direction: column;
    align-items: center;
    display: flex;
    position: relative
}

.content-panel-hero {
    width: 100%;
    height: auto;
    min-height: 100svh;
    color: #2e2a33;
    background-color: #fff;
    margin-top: auto;
    padding: 80px 48px;
    font-family: Mulish, sans-serif;
    font-size: 18px;
    line-height: 28px;
    display: block;
    overflow: hidden
}

.content-panel-hero.background-purple100 {
    min-height: 100svh;
    background-color: #f8f8ff
}

.content-panel-hero.background-gradient-light {
    min-height: 100vh;
    background-image: linear-gradient(204deg, #fff, #e2e7ff 50%, #f4cbf8);
    justify-content: center;
    padding-top: 0;
    display: flex;
    overflow: hidden
}

.content-panel-hero.background-gradient-light.home {
    padding-top: 120px
}

.content-panel-hero.background-gradient-dark {
    min-height: 100svh;
    background-image: linear-gradient(204deg, #efd6f5, #c2d1ff 50%, #d9eafb);
    justify-content: center;
    display: flex;
    overflow: hidden
}

.content-panel-hero.no-min-height {
    min-height: auto;
    flex-direction: column;
    align-items: center;
    display: flex
}

.content-panel-usp1 {
    width: 100%;
    height: auto;
    min-height: 100svh;
    color: #2e2a33;
    background-color: #fff;
    margin-top: auto;
    padding: 80px 48px;
    font-family: Mulish, sans-serif;
    font-size: 18px;
    line-height: 28px;
    display: block;
    overflow: hidden
}

.content-panel-usp1.background-purple100 {
    min-height: 100svh;
    background-color: #f8f8ff
}

.content-panel-usp1.background-gradient-light {
    min-height: 100vh;
    background-image: linear-gradient(204deg, #fff, #e2e7ff 50%, #f4cbf8);
    justify-content: center;
    display: flex;
    overflow: hidden
}

.content-panel-usp1.background-gradient-dark {
    min-height: 100svh;
    background-image: linear-gradient(204deg, #efd6f5, #c2d1ff 50%, #d9eafb);
    justify-content: center;
    display: flex;
    overflow: hidden
}

.content-panel-usp1.no-min-height {
    min-height: auto;
    flex-direction: column;
    align-items: center;
    display: flex
}

.content-panel-usp2 {
    width: 100%;
    height: auto;
    min-height: 100svh;
    background-color: var(--purple-100);
    color: #2e2a33;
    margin-top: auto;
    padding: 80px 48px;
    font-family: Mulish, sans-serif;
    font-size: 18px;
    line-height: 28px;
    display: block;
    overflow: hidden
}

.content-panel-usp2.background-purple100 {
    min-height: 100svh;
    background-color: #f8f8ff
}

.content-panel-usp2.background-gradient-light {
    min-height: 100vh;
    background-image: linear-gradient(204deg, #fff, #e2e7ff 50%, #f4cbf8);
    justify-content: center;
    display: flex;
    overflow: hidden
}

.content-panel-usp2.background-gradient-dark {
    min-height: 100svh;
    background-image: linear-gradient(204deg, #efd6f5, #c2d1ff 50%, #d9eafb);
    justify-content: center;
    display: flex;
    overflow: hidden
}

.content-panel-usp2.no-min-height {
    min-height: auto;
    flex-direction: column;
    align-items: center;
    display: flex
}

.content-panel-usp3 {
    width: 100%;
    height: auto;
    min-height: 100svh;
    color: #2e2a33;
    background-color: #fff;
    margin-top: auto;
    padding: 80px 48px;
    font-family: Mulish, sans-serif;
    font-size: 18px;
    line-height: 28px;
    display: block;
    overflow: hidden
}

.content-panel-usp3.background-purple100 {
    min-height: 100svh;
    background-color: #f8f8ff
}

.content-panel-usp3.background-gradient-light {
    min-height: 100vh;
    background-image: linear-gradient(204deg, #fff, #e2e7ff 50%, #f4cbf8);
    justify-content: center;
    display: flex;
    overflow: hidden
}

.content-panel-usp3.background-gradient-dark {
    min-height: 100svh;
    background-image: linear-gradient(204deg, #efd6f5, #c2d1ff 50%, #d9eafb);
    justify-content: center;
    display: flex;
    overflow: hidden
}

.content-panel-usp3.no-min-height {
    min-height: auto;
    flex-direction: column;
    align-items: center;
    display: flex
}

.mod-3_t2, .mod-3_t3 {
    display: none
}

.m3-see-2 {
    grid-column-gap: 11px;
    grid-row-gap: 11px;
    cursor: pointer;
    align-items: center;
    display: flex
}

.m3-see-2.hide {
    display: none
}

.m3-see-3 {
    grid-column-gap: 11px;
    grid-row-gap: 11px;
    cursor: pointer;
    align-items: center;
    display: flex
}

.m3-see-3.hide {
    display: none
}

.m3-see-1 {
    grid-column-gap: 11px;
    grid-row-gap: 11px;
    cursor: pointer;
    align-items: center;
    display: none
}

.m3-see-1.hide {
    display: none
}

.mod-1_p1-copy {
    width: 712.22px;
    height: 429.52px;
    object-fit: cover;
    margin-top: -9px;
    display: block
}

.mod-1_p1-copy.hidden {
    display: none
}

.mod-3_p2 {
    width: 712.22px;
    height: 579.25px;
    object-fit: cover;
    margin-top: -9px;
    display: block
}

.mod-3_p2.hidden {
    display: none
}

.mod-3_p1 {
    width: 712.22px;
    height: 464.57px;
    object-fit: cover;
    margin-top: -9px;
    display: block
}

.mod-3_p1.hidden {
    display: none
}

.image-18, .mod-3_p3 {
    display: none;
    position: absolute;
    top: auto;
    bottom: 2%;
    left: auto;
    right: -5%
}

.vp1_s2 {
    object-fit: cover;
    display: none
}

.vp1_s2.current {
    display: block
}

.vp1_s3 {
    object-fit: cover;
    display: none
}

.vp1_s3.current {
    display: block
}

.dot-1 {
    width: 16px;
    height: 16px;
    border: 1.5px solid var(--dashboardblue);
    background-color: var(--dashboardblue);
    cursor: pointer;
    border-radius: 8px
}

.dot-1.active {
    background-color: var(--dashboardblue);
    cursor: auto
}

.dot-3 {
    width: 16px;
    height: 16px;
    border: 1.5px solid var(--dashboardblue);
    cursor: pointer;
    background-color: #fff;
    border-radius: 8px
}

.dot-3.active {
    background-color: var(--dashboardblue);
    cursor: auto
}

.panel-visual-modules {
    width: 100%;
    min-height: 250px;
    grid-column-gap: 0px;
    grid-row-gap: 0px;
    flex-direction: column;
    justify-content: flex-start;
    align-self: center;
    align-items: center;
    margin-top: 60px;
    display: flex;
    position: relative;
    top: 0;
    left: 0;
    right: 0
}

.panel-visual-modules.cards {
    justify-content: space-between
}

.panel-visual-modules.side-by-side {
    width: auto;
    max-width: 48%;
    justify-content: flex-end;
    margin-top: 0;
    margin-left: 0;
    margin-right: 0
}

.panel-visual-modules.logos {
    min-height: 100px
}

.vp2_m-1 {
    justify-content: center;
    align-items: center;
    display: none
}

.vp2_mod1 {
    object-fit: cover;
    align-self: auto
}

.vp2_mod1.reduced {
    width: 560px
}

.vp2_mod2 {
    object-fit: cover
}

.vp2_mod2.reduced {
    width: 560px
}

.vp2_mod3 {
    height: auto;
    object-fit: cover
}

.vp2_mod3.reduced {
    width: 560px
}

.vp2_c-1 {
    width: 700px;
    height: auto;
    grid-column-gap: 10px;
    grid-row-gap: 10px;
    text-align: center;
    flex-direction: row;
    align-self: center;
    align-items: flex-end;
    padding-bottom: 0;
    display: none;
    position: relative
}

.image-22 {
    opacity: .5;
    margin-bottom: 10px
}

.vp2_a3-r {
    opacity: .5;
    margin-bottom: 15px;
    display: none
}

.slide {
    width: 80%
}

.slider-2 {
    justify-content: center;
    display: flex
}

.mask {
    align-self: center;
    margin-left: auto;
    margin-right: auto
}

.div-block-11 {
    width: 100%;
    background-color: var(--purple-600-light)
}

.vp2_m-2, .vp2_modules-1-copy {
    justify-content: center;
    align-items: center;
    display: flex
}

.vp2_m-3 {
    justify-content: center;
    align-items: center;
    display: none
}

.vp2-text {
    width: 90%;
    flex-direction: column;
    align-self: center;
    align-items: flex-start;
    display: flex
}

.vp2_c-2 {
    width: 700px;
    height: auto;
    grid-column-gap: 10px;
    grid-row-gap: 10px;
    text-align: center;
    flex-direction: row;
    align-self: center;
    align-items: flex-end;
    padding-bottom: 0;
    position: relative
}

.vp2_c-3 {
    width: 700px;
    height: auto;
    grid-column-gap: 10px;
    grid-row-gap: 10px;
    text-align: center;
    flex-direction: row;
    align-self: center;
    align-items: flex-end;
    padding-bottom: 0;
    display: flex;
    position: relative
}

.slider-arrow {
    width: 72px;
    height: 72px;
    background-color: #fff;
    top: 0;
    left: 0
}

.slider-arrow.right {
    top: 0;
    left: auto;
    right: 0
}

.slide-2 {
    object-fit: contain;
    position: relative
}

.slider-mask {
    width: 25%;
    margin-left: auto;
    margin-right: auto;
    display: block;
    overflow: visible
}

.slider-wrap {
    flex-direction: column;
    justify-content: center;
    align-items: center;
    display: flex
}

.extra-img-content {
    z-index: 2;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    display: flex;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0
}

.extra-img {
    width: 95%;
    position: absolute;
    top: 0;
    bottom: 0;
    left: -97.5%
}

.extra-img.last-slide {
    top: 0;
    bottom: 0;
    left: auto;
    right: -97.5%
}

.slider-arrow-icon {
    color: #000;
    font-size: 22px
}

.main-img {
    width: 95%;
    margin-left: auto;
    margin-right: auto;
    display: block
}

.slide-content {
    z-index: 2;
    width: 95%;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin-left: auto;
    margin-right: auto;
    display: flex;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0
}

.slide-overlay {
    z-index: 1;
    width: 95%;
    background-color: rgba(0, 0, 0, .45);
    margin-left: auto;
    margin-right: auto;
    display: block;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0
}

.slide-overlay.extra-img-overlay {
    width: auto
}

.slide-nav {
    display: none
}

.slider-3 {
    width: 100%;
    height: 50vh;
    background-color: transparent;
    overflow: hidden
}

.vp2_a2-l, .vp2_a1-l, .vp2_a1-r, .vp2_a3-l {
    opacity: .5;
    margin-bottom: 15px;
    display: none
}

.moddotframe {
    height: 10px;
    grid-column-gap: 12px;
    grid-row-gap: 12px;
    justify-content: center;
    align-items: flex-end;
    display: flex
}

.vp3_t1 {
    display: block
}

.vp3_t2, .vp3_t3 {
    display: none
}

.vp3_as2 {
    grid-column-gap: 11px;
    grid-row-gap: 11px;
    cursor: pointer;
    align-items: center;
    display: flex
}

.vp3_as2.hide {
    display: none
}

.vp3_as3 {
    grid-column-gap: 11px;
    grid-row-gap: 11px;
    cursor: pointer;
    align-items: center;
    display: flex
}

.vp3_as3.hide {
    display: none
}

.vp3_as1 {
    grid-column-gap: 11px;
    grid-row-gap: 11px;
    cursor: pointer;
    align-items: center;
    display: none
}

.vp3_as1.hide {
    display: none
}

.vp3_s1 {
    object-fit: cover;
    display: block
}

.vp3_s1.current {
    display: block
}

.vp3_s2 {
    object-fit: cover;
    display: none
}

.vp3_s2.current {
    display: block
}

.vp3_s3 {
    object-fit: cover;
    display: none
}

.vp3_s3.current {
    display: block
}

.button {
    z-index: 10;
    background-color: var(--purple-600-light);
    border-radius: 21px;
    font-size: 16px;
    font-weight: 700;
    position: relative
}

.button:hover {
    background-color: var(--purple-1000-dark)
}

.button:active {
    background-color: rgba(143, 81, 255, .5)
}

.button.solid-button {
    align-self: center;
    margin-top: 0
}

.button.solid-button.cta.button-oultine {
    width: auto;
    height: 56px;
    flex: 0 auto;
    align-self: auto;
    margin-top: 0;
    padding-top: 9px;
    padding-bottom: 9px
}

.button.solid-button.cta.button-oultine:hover {
    color: #fff
}

.button.solid-button {
    width: 150px;
    flex-direction: column;
    align-self: center;
    margin-top: 60px;
    display: flex
}

.button.button-solid:hover {
    border-color: var(--purple-1000-dark)
}

.button.button-outline {
    height: 56px;
    border: 2px solid var(--purple-600-light);
    color: var(--purple-600-light);
    background-color: #fff;
    border-radius: 28px;
    justify-content: center;
    align-items: center;
    padding-left: 40px;
    padding-right: 40px;
    display: flex
}

.button.button-outline:hover {
    border-color: var(--purple-1000-dark);
    background-color: var(--purple-1000-dark);
    color: #fff;
    -webkit-text-stroke-color: var(--purple-1000-dark)
}

.form-heading {
    font-size: 40px
}

.link {
    color: #fff;
    text-align: center;
    margin-left: auto;
    margin-right: auto;
    font-size: 20px;
    font-style: normal;
    line-height: 20px;
    text-decoration: none;
    position: relative;
    top: 25%;
    left: 0%;
    right: 0%
}

.container-3 {
    width: auto;
    max-width: 100%;
    background-color: #fff;
    border-radius: 8px
}

.text-span-3 {
    font-weight: 400
}

.text-field {
    width: 100%
}

.pop-up-form {
    width: auto;
    opacity: 1;
    justify-content: space-between;
    padding: 40px;
    display: block;
    position: static
}

.work-details-container {
    justify-content: space-between;
    display: flex
}

.form {
    width: auto;
    grid-column-gap: 40px;
    grid-row-gap: 40px;
    flex-direction: row;
    grid-template-rows: auto auto;
    grid-template-columns: 1fr 1fr;
    grid-auto-columns: 1fr;
    justify-content: space-between;
    align-items: stretch;
    display: flex
}

.form-text-contaner {
    width: 300px;
    flex: 0 auto;
    margin-right: 0;
    padding-right: 0
}

.pop-up-wrapper {
    z-index: 9999;
    grid-column-gap: 16px;
    grid-row-gap: 16px;
    opacity: 0;
    background-color: rgba(0, 0, 0, .8);
    flex-direction: column;
    grid-template-rows: auto auto;
    grid-template-columns: 1fr 1fr;
    grid-auto-columns: 1fr;
    justify-content: center;
    align-items: center;
    font-family: Mulish, sans-serif;
    display: none;
    position: fixed;
    top: 0%;
    bottom: 0%;
    left: 0%;
    right: 0%
}

.cancel-container {
    width: 40px;
    height: 40px;
    text-align: center;
    background-color: #9450ff;
    border-radius: 50%;
    margin-left: auto;
    margin-right: auto;
    display: block;
    position: relative;
    top: -20px;
    left: 50%;
    right: 0%
}

.upper-fields-container {
    width: 48%
}

.form-container {
    width: 600px;
    padding-left: 0
}

.container-4 {
    height: 650px;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    display: flex
}

.container-5 {
    width: auto;
    max-width: 100%;
    background-color: #fff
}

.kpi-module {
    grid-column-gap: 24px;
    grid-row-gap: 24px;
    background-color: #fff;
    border-radius: 14px;
    flex-direction: column;
    padding: 24px;
    display: flex;
    position: relative;
    box-shadow: 0 0 20px 4px rgba(225, 218, 253, .25)
}

.expand {
    width: 40px;
    height: 40px;
    background-color: var(--purple-300);
    border-radius: 20px;
    justify-content: center;
    align-items: center;
    display: flex;
    position: absolute;
    top: 24px;
    bottom: auto;
    left: auto;
    right: 24px
}

.expand-icon {
    width: 16px;
    height: 16px
}

.kpi-icon {
    width: 80px;
    height: 80px;
    background-color: var(--purple-200);
    border-radius: 40px
}

.kpi-moduletitle {
    grid-column-gap: 8px;
    grid-row-gap: 8px;
    flex-direction: column;
    display: flex
}

.kpi-modules {
    width: 100%;
    grid-column-gap: 24px;
    grid-row-gap: 24px;
    flex-wrap: wrap;
    grid-template-rows: auto auto;
    grid-template-columns: 1fr 1fr 1fr;
    grid-auto-columns: 1fr;
    padding: 24px;
    display: grid
}

.panel-modules {
    position: relative
}

.kpi-overlays {
    z-index: 50;
    width: 100%;
    height: auto;
    flex-direction: column;
    display: flex;
    position: absolute;
    top: 0%;
    bottom: auto;
    left: 0%;
    right: auto
}

.kpi-overlay {
    width: auto;
    height: auto;
    max-width: 1200px;
    grid-column-gap: 80px;
    grid-row-gap: 80px;
    background-color: #fff;
    border-radius: 14px;
    flex-direction: column;
    align-items: center;
    margin-right: 0;
    padding: 0 10px 80px 80px;
    display: none;
    position: fixed;
    top: 40px;
    bottom: 40px;
    left: auto;
    right: auto;
    overflow: visible;
    box-shadow: 0 0 20px 4px #e1dafd
}

.kpi-icon-large {
    width: 176px;
    height: 176px;
    background-color: #ebe7fe;
    border-radius: 40px;
    margin-bottom: 40px
}

.kpi-icon-large.green {
    background-color: #d5f2f1
}

.kpi-overlay-title {
    align-self: flex-start;
    position: relative
}

.kpi-overlay-section {
    position: relative
}

.heading-3 {
    font-size: 60px;
    line-height: 70px
}

.kpi-heading-h2 {
    font-size: 60px;
    font-weight: 800;
    line-height: 70px
}

.kpi-subhead {
    line-height: 28px
}

.kpi-overlay-details {
    height: auto;
    grid-column-gap: 40px;
    grid-row-gap: 40px;
    flex-direction: column;
    display: flex;
    position: relative
}

.close {
    z-index: 150;
    width: 40px;
    height: 40px;
    background-color: var(--purple-600-light);
    border-radius: 20px;
    justify-content: center;
    align-items: center;
    display: flex;
    position: absolute;
    top: 40px;
    bottom: auto;
    left: auto;
    right: 40px
}

.kpi-overlay-contentscroll {
    width: 100%;
    height: 100%;
    grid-column-gap: 80px;
    grid-row-gap: 80px;
    flex-direction: column;
    margin-top: 20px;
    margin-right: 0;
    padding-top: 60px;
    padding-right: 70px;
    display: flex;
    position: relative;
    overflow: scroll
}

.fs-scrolldisable_wrapper {
    grid-column-gap: 1rem;
    grid-row-gap: 1rem;
    grid-template-rows: auto;
    grid-template-columns: auto;
    grid-auto-columns: auto;
    grid-auto-flow: column;
    align-items: center;
    justify-items: start;
    display: grid;
    position: relative
}

.fs-scrolldisable_button {
    color: #fff;
    background-color: #5c2aff;
    border-radius: 500px;
    padding: .6rem 2rem
}

.div-block-12 {
    margin-top: 220px
}

.panel-subheading {
    font-size: 36px;
    line-height: 42px
}

.panel-subheading.informal {
    color: var(--purple-1000-dark);
    text-align: left;
    margin-top: 0;
    margin-bottom: 42px;
    font-family: Mulish, sans-serif;
    font-weight: 600;
    position: relative
}

.panel-subheading.informal.center {
    text-align: center
}

.panel-subheading.feature {
    margin-top: 0
}

.panel-subheading.feature.usecase {
    color: var(--purple-1000-dark)
}

.panel-visual {
    width: 50%;
    height: auto;
    flex-direction: column;
    align-items: center;
    display: flex
}

.panel-visual.screen {
    width: 50%;
    height: auto;
    margin-left: 60px
}

.panel-visual.screen.wcaption {
    flex-direction: column;
    align-items: center;
    display: flex
}

.panel-visual.feature {
    width: 40%;
    align-items: center
}

.panel-visual.feature.exta {
    margin-left: 40px
}

.panel-visual.feature.outline {
    grid-column-gap: 5px;
    grid-row-gap: 5px;
    margin-top: 0
}

.panel-visual.infographic {
    width: 45%;
    height: auto;
    padding-bottom: 20px
}

.panel-visual.infographic.extradown {
    padding-bottom: 0
}

.content-panel-story {
    width: 100%;
    height: auto;
    max-width: none;
    min-height: 100svh;
    color: #2e2a33;
    background-color: #fff;
    margin-top: auto;
    padding: 220px 48px 80px;
    font-family: Mulish, sans-serif;
    font-size: 18px;
    line-height: 28px;
    display: block;
    overflow: hidden
}

.content-panel-story.background-purple100 {
    min-height: 100svh;
    background-color: var(--purple-100)
}

.content-panel-story.background-purple100.varheight, .content-panel-story.background-purple100.varheight-2 {
    margin-top: 0
}

.content-panel-story.background-gradient-light {
    min-height: 100vh;
    background-image: linear-gradient(204deg, #fff, #e2e7ff 50%, #f4cbf8);
    justify-content: center;
    display: flex;
    overflow: hidden
}

.content-panel-story.background-gradient-dark {
    min-height: 100svh;
    background-image: linear-gradient(204deg, #efd6f5, #c2d1ff 50%, #d9eafb);
    justify-content: center;
    display: flex;
    overflow: hidden
}

.content-panel-story.no-min-height {
    min-height: auto;
    flex-direction: column;
    align-items: center;
    display: flex
}

.content-panel-story.first {
    max-width: none;
    padding-top: 170px
}

.content-panel-story.first.background_purple-100 {
    width: 100%;
    max-width: none;
    background-color: var(--purple-100);
    justify-content: center;
    display: flex;
    overflow: visible
}

.content-panel-story.first.grandient {
    background-image: linear-gradient(34deg, var(--purple-200), #e9f7ff 100%, white)
}

.content-panel-story.first.grandient.informal {
    min-height: auto;
    padding-top: 139px;
    padding-bottom: 20px
}

.content-panel-story.background-purple10 {
    background-color: var(--purple-100)
}

.content-panel-story.varheight, .content-panel-story.varheight-2 {
    min-height: auto;
    align-self: flex-start;
    align-items: flex-start;
    padding-top: 140px;
    padding-bottom: 140px;
    display: flex;
    position: relative
}

.fs-mirrorclick_wrapper {
    width: 100%;
    flex-direction: column;
    align-items: flex-start;
    margin-top: 220px;
    display: flex
}

.fs-mirrorclick_grid {
    grid-column-gap: 2rem;
    grid-row-gap: 2rem;
    grid-template-rows: auto;
    grid-template-columns: auto;
    grid-auto-columns: auto;
    grid-auto-flow: column;
    margin-bottom: 2rem;
    display: grid
}

.fs-mirrorclick_button {
    color: #fff;
    background-color: #5c2aff;
    border-radius: 500px;
    padding: .6rem 2rem .65rem
}

.fs-mirrorclick_button:hover {
    background-color: #6739ff
}

.fs-mirrorclick_slider {
    width: 100%;
    background-color: #474747
}

.fs-mirrorclick_slide-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: 50% 35%
}

.fs-mirrorclick_arrow-left, .fs-mirrorclick_arrow-right {
    color: #111
}

.bullet {
    width: 12px;
    max-width: 100%;
    text-align: center;
    align-self: flex-start;
    margin-bottom: 8px;
    line-height: 25px;
    position: static
}

.bullet.left {
    text-align: left
}

.panel-bulletpoint {
    grid-column-gap: 10px;
    grid-row-gap: 10px;
    flex-direction: row;
    align-items: flex-start;
    display: flex
}

.panel-bulletpoints {
    grid-column-gap: 4px;
    grid-row-gap: 4px;
    flex-direction: column;
    display: flex
}

.scrollandsee-text {
    color: var(--purple-600-light);
    -webkit-text-stroke-color: var(--purple-600-light);
    font-size: 16px;
    font-weight: 600;
    line-height: 25px;
    text-decoration: none
}

.div-block-13 {
    text-align: center;
    margin-top: 15vh;
    position: relative;
    top: auto;
    bottom: auto;
    left: 0%;
    right: 0%
}

.chevrondown {
    height: 18px
}

.scrollandsee {
    grid-column-gap: 8px;
    grid-row-gap: 8px;
    justify-content: center;
    align-items: center;
    padding-top: 10px;
    text-decoration: none;
    display: flex;
    position: relative
}

.scrollandsee.w--current {
    text-decoration: none
}

.panel-quote {
    font-size: 36px;
    line-height: 42px
}

.panel-quote.informal {
    text-align: center;
    margin-top: 0;
    font-family: ivypresto-headline, sans-serif;
    font-weight: 600;
    position: relative
}

.panel-quote.informal.cloud {
    color: var(--purple-1000-dark);
    font-size: 48px;
    font-style: normal;
    font-weight: 700;
    line-height: 50px
}

.caption-text {
    color: var(--purple-1000-dark);
    text-align: center;
    padding-left: 15%;
    padding-right: 15%;
    font-size: 16px;
    line-height: 25px
}

.caption-text.usecase {
    padding-left: 5%;
    padding-right: 5%
}

.screenshadow {
    width: 99.9986%;
    height: 80%;
    object-fit: cover;
    border-radius: 16px;
    position: relative;
    box-shadow: 0 0 5px rgba(0, 0, 0, .2)
}

.nav-menu {
    background-color: transparent
}

.icon {
    color: #000;
    background-color: transparent
}

.menu-button {
    background-color: #c8c8c8
}

.menu-button.w--open {
    background-color: transparent
}

.mobile-navbar {
    color: #000;
    background-color: transparent;
    margin-top: 0;
    display: none
}

.logo-mb {
    height: 50px;
    padding-top: 10px;
    padding-bottom: 10px
}

.text-block-15 {
    font-family: Mulish, sans-serif;
    font-size: 16px;
    line-height: 25px
}

.heading-4 {
    font-family: Mulish, sans-serif;
    font-size: 60px;
    font-weight: 800;
    line-height: 70px
}

.image-23 {
    margin-bottom: 40px
}

.image-24 {
    width: 80%;
    text-align: center;
    display: block
}

.panel-subheading-step {
    font-size: 36px;
    line-height: 42px
}

.panel-subheading-step.informal {
    color: var(--purple-600-light);
    text-align: left;
    margin-top: 0;
    margin-bottom: 0;
    font-family: Mulish, sans-serif;
    font-weight: 700;
    position: relative
}

.panel-focusarea {
    color: var(--sky);
    font-size: 16px;
    font-weight: 800;
    line-height: 25px
}

.panel-focusarea.sky {
    color: var(--sky)
}

.panel-focusarea.wine {
    color: var(--wine)
}

.panel-focusarea.grass {
    color: var(--grass)
}

.panel-focusarea.candy {
    color: var(--candy)
}

.panel-focusarea.emerald {
    color: var(--emerald)
}

.panel-focusarea.peacock {
    color: var(--peacock)
}

.panel-focusarea.purple {
    color: var(--purple-600-light);
    font-size: 24px;
    line-height: 28px
}

.panel-focusarea.latanapurple {
    color: var(--purple-600-light)
}

.infographic {
    height: 250px
}

.infographic.chart {
    height: 300px
}

.extraspace {
    margin-bottom: 10px
}

.screen {
    object-fit: contain
}

.scale {
    width: 80%
}

.pricing-toggle {
    grid-column-gap: 10px;
    grid-row-gap: 10px;
    align-items: center;
    display: flex
}

.yearly {
    color: var(--purple-600-light);
    font-weight: 800
}

.montly {
    font-weight: 700
}

.toggle {
    width: 80px;
    height: 44px;
    background-color: var(--purple-600-light);
    border-radius: 22px;
    justify-content: flex-end;
    align-items: center;
    padding-left: 2px;
    padding-right: 2px;
    display: flex;
    position: relative
}

.thumb-slider {
    width: 40px;
    height: 40px;
    background-color: #fff;
    border-radius: 20px
}

.pricing-package {
    width: 40%;
    background-color: #fff;
    border-radius: 14px;
    flex-direction: column;
    padding: 40px 24px;
    display: flex;
    box-shadow: 0 0 20px 4px #e1dafd
}

.pricing-packages {
    width: 100%;
    grid-column-gap: 20px;
    grid-row-gap: 20px;
    justify-content: space-between;
    padding: 50px 20px 20px;
    display: flex
}

.package-title {
    text-align: center;
    font-size: 28px;
    font-weight: 800;
    line-height: 36px
}

.package-description {
    height: 115px
}

.package-price {
    font-size: 40px;
    font-weight: 800;
    line-height: 48px
}

.package-permonth {
    grid-column-gap: 4px;
    grid-row-gap: 4px;
    font-size: 12px;
    line-height: 18px;
    display: flex
}

.package-top {
    height: 375px;
    grid-column-gap: 16px;
    grid-row-gap: 16px;
    border-bottom: 0 solid #cecece;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 40px;
    display: flex
}

.div-block-14 {
    grid-column-gap: 4px;
    grid-row-gap: 4px;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin-top: 8px;
    margin-bottom: 8px;
    padding-top: 0;
    display: flex
}

.button-oultine {
    height: 56px;
    border: 2px solid var(--purple-600-light);
    color: var(--purple-600-light);
    background-color: #fff;
    border-radius: 28px;
    align-items: center;
    padding-left: 40px;
    padding-right: 40px;
    font-weight: 800;
    display: flex
}

.button-solid {
    height: 56px;
    border: 2px solid var(--purple-600-light);
    background-color: var(--purple-600-light);
    color: #fff;
    -webkit-text-stroke-color: #fff;
    border-radius: 28px;
    align-items: center;
    padding-left: 40px;
    padding-right: 40px;
    font-weight: 800;
    display: flex
}

.package-includes {
    grid-column-gap: 24px;
    grid-row-gap: 24px;
    flex-direction: column;
    flex: 0 auto;
    margin-top: 100px;
    padding-top: 0;
    display: flex
}

.checkmark {
    width: 28px;
    height: 28px;
    min-width: 28px;
    text-align: center;
    align-self: flex-start;
    margin-bottom: 0;
    line-height: 25px;
    position: static
}

.checkmark.left {
    text-align: left
}

.pricing-bullet-text {
    text-align: left;
    align-self: center;
    margin-bottom: 0;
    line-height: 25px;
    position: static
}

.pricing-bullet-text.git {
    text-align: center
}

.pricing-bullet-text.left {
    text-align: left;
    align-self: flex-start
}

.pricing-bullet-text.left.center {
    text-align: center;
    align-self: center;
    position: relative
}

.pricing-bullet-text.center.cloud {
    color: var(--purple-1000-dark);
    font-weight: 700
}

.pricing-bulletpoint {
    grid-column-gap: 10px;
    grid-row-gap: 10px;
    flex-direction: row;
    align-items: flex-start;
    padding-left: 5px;
    display: flex
}

.pricing-bulletpoints {
    grid-column-gap: 8px;
    grid-row-gap: 8px;
    flex-direction: column;
    display: flex
}

.pricingtable-c1 {
    width: 290px;
    grid-column-gap: 0px;
    grid-row-gap: 0px;
    border-right: 1px solid #eeeefb;
    flex-direction: column;
    grid-template-rows: auto auto;
    grid-template-columns: 1.5fr 1fr 1fr 1fr;
    grid-auto-columns: 1fr;
    align-items: flex-start;
    display: flex
}

.pricingtable {
    width: auto;
    align-items: flex-start;
    display: flex
}

.div-block-15 {
    width: 290px
}

.div-block-16 {
    width: 26%
}

.div-block-17 {
    width: 100%
}

.div-block-18 {
    width: 100px
}

.div-block-19, .div-block-20 {
    height: 290px
}

.div-block-21 {
    height: 0
}

.div-block-22 {
    background-color: var(--purple-600-light)
}

.pricingtable-textrow {
    width: 100%;
    height: 75px;
    background-color: transparent;
    align-self: center;
    align-items: center;
    display: flex
}

.pricingtable-textrow.title {
    border-top: 1px solid var(--lavender);
    justify-content: flex-start;
    align-items: center;
    font-size: 24px;
    font-weight: 800;
    line-height: 36px;
    display: flex
}

.pricingtable-textrow.columnheader {
    text-align: center;
    font-size: 28px;
    font-weight: 800;
    line-height: 36px
}

.pricingtable-txt {
    width: 100%
}

.pricingtable-c2 {
    width: 290px;
    grid-column-gap: 0px;
    grid-row-gap: 0px;
    border-right: 1px solid #eeeefb;
    flex-direction: column;
    grid-template-rows: auto auto;
    grid-template-columns: 1.5fr 1fr 1fr 1fr;
    grid-auto-columns: 1fr;
    justify-content: center;
    align-items: center;
    display: flex
}

.pricingtable-c2.last {
    border-right-style: none
}

.check {
    width: 100%;
    height: 100%;
    justify-content: center;
    align-items: center;
    display: flex
}

.faqs {
    width: 80%;
    flex-direction: column;
    align-items: flex-start;
    display: flex
}

.faq {
    width: 100%;
    height: auto;
    grid-column-gap: 8px;
    grid-row-gap: 8px;
    border-bottom: 1px solid #d0d3fd;
    flex-direction: column;
    justify-content: space-between;
    align-items: flex-start;
    padding-top: 32px;
    padding-bottom: 32px;
    padding-right: 32px;
    display: flex
}

.question {
    font-size: 24px;
    font-weight: 700
}

.arrow {
    display: none
}

.dropdown-list-3 {
    width: 100svw;
    background-color: var(--sky);
    align-items: flex-start;
    display: flex;
    bottom: 0%;
    left: 0%;
    right: auto
}

.navbar {
    z-index: 5;
    width: 100%;
    height: 90px;
    -webkit-backdrop-filter: blur(20px);
    backdrop-filter: blur(20px);
    background-color: rgba(255, 255, 255, .85);
    justify-content: space-between;
    align-items: center;
    display: flex;
    position: fixed;
    top: 0%;
    bottom: auto;
    left: 0%;
    right: 0%
}

.navbar-dropdowncontainer {
    z-index: 0;
    background-color: rgba(255, 255, 255, .85);
    margin-top: 50px;
    margin-bottom: 50px;
    padding-top: 0;
    position: fixed;
    top: 0
}

.navbar-dropdowncontainer.w--open {
    width: 100vw;
    -webkit-backdrop-filter: blur(5px);
    backdrop-filter: blur(5px);
    background-color: #fff;
    justify-content: center;
    align-items: flex-start;
    margin-top: 0;
    margin-bottom: 0;
    padding-top: 0;
    display: flex;
    top: 90px;
    left: 0;
    box-shadow: 0 9px 5px -6px rgba(0, 0, 0, .1)
}

.container-7 {
    width: 100%;
    max-width: 1200px;
    grid-column-gap: 0%;
    grid-row-gap: 0%;
    flex: 0 auto;
    justify-content: center;
    align-items: center;
    margin-left: 0;
    margin-right: 0;
    padding-left: 0;
    display: flex;
    position: relative
}

.navbar-linkitem {
    font-family: Mulish, sans-serif;
    font-size: 16px;
    font-weight: 600
}

.navbar-linkitem:hover {
    color: var(--purple-600-light)
}

.navbar-contentcontenter {
    z-index: 5;
    width: 100%;
    justify-content: space-between;
    display: flex;
    position: relative
}

.navbar-cta, .navbar-navitems {
    grid-column-gap: 30px;
    grid-row-gap: 30px;
    align-items: center;
    display: flex
}

.navbar-dropdownfullwidth {
    width: 100%;
    max-width: 1200px;
    align-items: flex-start;
    padding-top: 35px;
    padding-bottom: 50px;
    display: flex
}

.div-block-25 {
    width: 100%;
    justify-content: center;
    align-items: flex-start;
    display: flex
}

.navbar-menuitem {
    z-index: 0
}

.navbar-menuitem:hover {
    color: var(--purple-600-light)
}

.navbar-menuitem.product {
    z-index: 5
}

.latanalogo {
    z-index: 10
}

.solid-button-navbar {
    z-index: 10;
    height: 42px;
    background-color: var(--purple-600-light);
    color: #fff;
    text-align: center;
    cursor: pointer;
    border-radius: 21px;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 0 20px;
    font-size: 16px;
    font-weight: 800;
    line-height: 16px;
    display: flex;
    position: relative
}

.solid-button-navbar.content {
    margin-top: 16px
}

.solid-button-navbar.form-button {
    margin-top: 40px
}

.dropdown-toggle {
    z-index: 15
}

.div-block-26 {
    width: 100%;
    grid-column-gap: 20px;
    grid-row-gap: 20px;
    justify-content: flex-start;
    align-items: center;
    padding-right: 10px;
    display: flex
}

.dotblock {
    grid-column-gap: 10px;
    grid-row-gap: 10px;
    display: flex
}

.underscreenframe {
    grid-column-gap: 50px;
    grid-row-gap: 50px;
    justify-content: space-between;
    align-items: center;
    padding-top: 20px;
    padding-left: 20px;
    padding-right: 20px;
    display: flex
}

.div-block-27 {
    justify-content: center;
    display: flex
}

.div-block-28 {
    width: 75%
}

.screen-1 {
    width: 894px;
    height: 564px
}

.vp1-slider {
    width: 100%;
    height: 100%;
    background-color: #fff
}

.left-arrow {
    width: 50px;
    height: 50px;
    background-color: transparent;
    margin-top: 10px;
    margin-bottom: 0;
    top: 100%;
    bottom: 0%;
    left: 0%;
    right: auto
}

.left-arrow.center {
    top: 35%;
    left: -50px
}

.icon-2 {
    background-color: #d82f2f
}

.slide-nav-2 {
    height: 50px;
    background-color: transparent;
    margin-top: 10px;
    margin-bottom: 0;
    top: 100%
}

.right-arrow {
    width: 50px;
    height: 50px;
    background-color: transparent;
    margin-top: 10px;
    margin-bottom: 0;
    top: 100%
}

.right-arrow.center {
    top: 35%;
    right: -50px
}

.right-arrow.extra {
    margin-right: 40px
}

.slide-3 {
    object-fit: contain;
    margin-right: 0
}

.slide-1 {
    object-fit: contain
}

.mask-2 {
    object-fit: contain;
    margin-right: 0
}

.bold-text {
    font-weight: 400
}

.answer {
    max-width: 750px;
    font-size: 18px;
    font-weight: 400;
    line-height: 28px
}

.quote-text-2 {
    max-width: none;
    color: #340e70;
    padding-bottom: 6px;
    font-size: 17px;
    font-weight: 400;
    line-height: 24px
}

.dropdown-list {
    color: transparent;
    background-color: transparent;
    margin-top: 0;
    display: none
}

.dropdown-list:hover {
    display: block
}

.dropdown-list.w--open {
    border-radius: 21px;
    display: flex
}

.button-description-2 {
    max-width: none;
    color: #676767;
    font-size: 14px;
    font-weight: 400;
    line-height: 18px
}

.quote-description-2 {
    color: #676767;
    font-size: 14px;
    font-weight: 400;
    line-height: 18px
}

.menu-column-title-2 {
    height: 20px;
    color: #949494;
    margin-bottom: 28px;
    font-size: 17px;
    font-weight: 500
}

.button-text-2 {
    color: #340e70;
    font-size: 17px;
    font-weight: 400;
    line-height: 24px
}

.dropdown-3 {
    flex-direction: row;
    display: block
}

.dropdown-3:hover {
    color: var(--purple-600-light)
}

.menu-wrapper {
    width: 100vw;
    min-width: auto;
    clear: left;
    background-color: #fff;
    border-radius: 0;
    flex: 0 auto;
    justify-content: flex-start;
    padding: 40px;
    display: flex;
    position: relative;
    left: -37%;
    box-shadow: 0 20px 20px rgba(0, 0, 0, .2)
}

.dropdown-toggle-2 {
    display: block
}

.text-block-19 {
    font-size: 16px;
    font-weight: 700
}

.image-25 {
    position: relative
}

.inner-wrapper {
    width: 1200px;
    display: flex
}

.div-block-29 {
    width: 210px;
    flex: 0 auto;
    justify-content: space-between;
    display: flex
}

.div-block-30 {
    width: 650px;
    margin: 140px
}

.html-embed {
    width: 600px;
    height: 450px;
    transform: scale(1)
}

.panel-visual-modules-full {
    width: 100%;
    min-height: 250px;
    grid-column-gap: 0px;
    grid-row-gap: 0px;
    flex-direction: column;
    justify-content: flex-start;
    align-self: center;
    align-items: center;
    margin-top: 120px;
    display: flex;
    position: relative;
    top: 0;
    left: 0;
    right: 0
}

.panel-visual-modules-full.cards {
    justify-content: space-between
}

.panel-visual-modules-full.side-by-side {
    width: auto;
    max-width: 48%;
    justify-content: flex-end;
    margin-top: 0;
    margin-left: 0;
    margin-right: 0
}

.panel-visual-modules-full.logos {
    min-height: 100px
}

.slider-4 {
    width: auto;
    height: auto;
    background-color: transparent;
    justify-content: center;
    display: flex
}

.stackslidecontainer {
    width: 100%;
    max-width: 750px;
    flex-direction: column;
    align-items: center;
    display: flex
}

.mask-3 {
    width: 100%;
    max-width: 750px
}

.slidetext {
    width: 80%;
    text-align: center
}

.slidetext.ranking {
    text-align: left;
    margin-left: 68px
}

.slide-nav-3 {
    display: none
}

.vp2-screentitle {
    grid-column-gap: 20px;
    grid-row-gap: 20px;
    align-items: center;
    padding-left: 0;
    padding-right: 10px;
    display: flex
}

.cirlcenumber {
    width: 48px;
    height: 48px;
    border: 3px solid #000;
    border-radius: 24px;
    flex: none;
    justify-content: center;
    align-items: center;
    display: flex
}

.text-block-22 {
    text-align: center;
    font-size: 30px;
    font-weight: 800;
    line-height: 30px
}

.div-block-31 {
    width: 400px
}

.image-31 {
    max-width: 75%
}

.image-32 {
    width: 80%
}

.video {
    display: block
}

.image-33 {
    display: none
}

.image-34 {
    height: 40px
}

.image-35 {
    height: 60px;
    padding-bottom: 0
}

.image-37 {
    height: 30px
}

.image-39 {
    padding-top: 9px
}

.top-a {
    height: auto;
    min-height: 250px;
    grid-column-gap: 25px;
    grid-row-gap: 25px;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;
    display: flex
}

.top-b {
    width: 100%;
    grid-column-gap: 15px;
    grid-row-gap: 15px;
    flex-direction: column;
    align-items: center;
    display: flex
}

.button-scroll {
    z-index: 10;
    height: 42px;
    background-color: var(--purple-600-light);
    color: #fff;
    -webkit-text-stroke-color: white;
    border-radius: 21px;
    justify-content: space-between;
    align-items: center;
    padding: 0 20px;
    font-size: 16px;
    font-weight: 800;
    line-height: 16px;
    display: flex;
    position: relative
}

.button-scroll:hover {
    background-color: var(--purple-1000-dark);
    -webkit-text-stroke-color: var(--purple-1000-dark)
}

.bold-text-2 {
    font-size: 16px
}

.panel-text-footer {
    flex: 1;
    display: block
}

.image-42 {
    display: none
}

.legal-section {
    background-color: var(--purple-300);
    background-image: url(https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64bfad4d77d242c996c3096e_Legal_Hero.svg), linear-gradient(300deg, var(--purple-300), white);
    background-position: 100% -50%, 0 0;
    background-repeat: no-repeat, repeat;
    background-size: auto, auto;
    font-family: Mulish, sans-serif
}

.heading-tnc {
    align-items: flex-end;
    font-size: 60px;
    line-height: 60px;
    display: block
}

.legal-container {
    max-width: 1200px;
    padding-top: 140px;
    padding-bottom: 140px
}

.legal-main {
    font-family: Mulish, sans-serif
}

.aside {
    flex: none;
    margin-right: 40px;
    padding-top: 15px
}

.text-block-23 {
    padding-top: 10px;
    padding-bottom: 10px;
    font-family: Mulish, sans-serif
}

.bold-text-3 {
    font-size: 20px
}

.container-8 {
    display: flex
}

.dropdown-toggle-3 {
    padding-top: 10px
}

.heading-10 {
    font-size: 22px
}

.heading-11 {
    margin-top: 0;
    font-size: 20px
}

.text-block-24, .line-height-30 {
    font-size: 16px
}

.dropdown-list-4 {
    background-color: var(--purple-600-light)
}

.dropdown-list-4.w--open {
    background-color: transparent
}

.legal-links {
    font-size: 16px
}

.link-26 {
    color: var(--black);
    font-size: 20px;
    line-height: 22px;
    text-decoration: none
}

.link-26:hover {
    text-decoration: underline
}

.breadcrumb-item {
    padding-top: 10px
}

.page-padding {
    padding: 5em 5%
}

.page-padding.s0 {
    padding: 2em 0%;
    overflow: visible
}

.container-large {
    width: 100%;
    max-width: 80rem;
    margin-left: auto;
    margin-right: auto
}

.padding-vertical {
    padding-left: 0;
    padding-right: 0
}

.padding-vertical.padding-xxlarge {
    padding: 0
}

.logo_component-slider {
    width: 2900px;
    grid-column-gap: 2rem;
    grid-row-gap: 6rem;
    grid-template-rows: auto;
    grid-template-columns: max-content 1fr;
    grid-auto-columns: 1fr;
    justify-content: flex-start;
    align-items: center;
    display: flex;
    overflow: visible;
}

.logo-slider-img {
    width: 200px
}

.logo_component-slider-2 {
    width: 2200px;
    grid-column-gap: 6rem;
    grid-row-gap: 6rem;
    grid-template-rows: auto;
    grid-template-columns: max-content 1fr;
    grid-auto-columns: 1fr;
    justify-content: flex-start;
    align-items: center;
    display: flex
}

.link-27, .link-28, .link-29 {
    text-decoration: none
}

.body-2 {
    font-family: Mulish, sans-serif
}

.section-gradient {
    background-image: linear-gradient(258deg, #000, #00c6bc 0%, #9450ff);
    margin-top: 0;
    padding-top: 100px;
    padding-bottom: 100px
}

.heading-14 {
    color: #fff;
    text-align: center;
    margin-top: 40px;
    margin-bottom: 40px;
    font-size: 60px;
    font-weight: 800;
    line-height: 65px
}

.youtube {
    border-radius: 8px;
    margin-top: 40px
}

.card-grey-bg {
    height: 280px;
    text-align: center;
    background-color: #f4f4f4;
    border-radius: 8px;
    flex-direction: column;
    flex: 0 50%;
    justify-content: center;
    align-items: stretch;
    margin: 20px 0;
    padding: 0 10px;
    display: flex
}

.heading-15 {
    color: #662abc;
    font-family: ivypresto-display, sans-serif;
    font-size: 70px
}

.text-block-25, .text-block-26, .text-block-27 {
    font-size: 20px
}

.cards-text {
    padding-top: 20px;
    font-size: 20px
}

.container-9 {
    grid-column-gap: 20px;
    justify-content: space-between;
    display: flex
}

.section-cards {
    margin-top: 60px
}

.div-block-32 {
    flex: 1;
    margin-bottom: 0
}

.list-container {
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin-top: 40px;
    display: flex
}

.heading-purple {
    color: #662abc;
    font-family: ivypresto-display, sans-serif
}

.heading-purple.blue {
    color: #0c7fd0
}

.heading-purple.teal {
    color: #009b93
}

.heading-purple.orange {
    color: #ef4e1d
}

.heading-purple.fuschia {
    color: #be3aa7
}

.heading-ivy {
    width: auto;
    color: #662abc;
    font-family: ivypresto-display, sans-serif;
    font-size: 80px
}

.heading-ivy.blue {
    color: #0c7fd0
}

.heading-ivy.teal {
    color: #009b93
}

.heading-ivy.orange {
    color: #ef4e1d
}

.heading-ivy.fuschia {
    color: #be3aa7
}

.heading-ivy.red {
    color: #c50738
}

.listi-item-about-us {
    width: 600px;
    flex-direction: row;
    display: flex
}

.div-block-34 {
    margin-left: 40px
}

.step-block {
    min-height: 80vh;
    flex-wrap: nowrap;
    align-content: center;
    justify-content: space-around;
    align-items: center;
    margin-top: -1px;
    display: flex;
    position: relative
}

.bg-shadow {
    z-index: 1;
    border-radius: 16px;
    position: absolute;
    top: 0%;
    bottom: 0%;
    left: 0%;
    right: 0%;
    box-shadow: 7px 7px 20px rgba(18, 18, 18, .07)
}

.content-block {
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;
    display: flex;
    position: -webkit-sticky;
    position: sticky;
    top: 0
}

.img-block {
    width: 40%;
    justify-content: center;
    align-self: center;
    align-items: center;
    display: flex
}

.label {
    color: var(--purple-600-light);
    letter-spacing: 2px;
    -webkit-text-stroke-color: var(--purple-600-light);
    text-transform: uppercase;
    font-family: ivypresto-display, sans-serif;
    font-size: 50px;
    font-weight: 700;
    line-height: 60px
}

.scroll-base {
    width: 3px;
    height: 100%;
    outline-offset: 0px;
    transform-origin: 50% 0;
    background-color: #eeeff4;
    outline: 3px #333
}

.content-wrap {
    width: 40%;
    justify-content: flex-end;
    display: flex
}

.timeline-section {
    margin-top: 60px
}

.steps-clone {
    flex-direction: column;
    justify-content: center;
    margin-top: 0;
    display: flex;
    position: relative
}

.scroll-animate {
    width: 3px;
    height: 100%;
    background-color: var(--purple-600-light);
    transform-origin: 50% 0;
    -webkit-text-fill-color: inherit;
    background-clip: border-box;
    border: 1px #000;
    position: absolute;
    bottom: 0
}

.step-content-block {
    text-align: left;
    align-self: center;
    position: relative
}

.heading-21 {
    height: auto;
    min-height: 0;
    background-color: var(--purple-600-light);
    color: #fff;
    object-fit: fill;
    margin-top: 10px;
    margin-bottom: 10px;
    padding: 5px 10px;
    font-weight: 800;
    display: inline-block
}

.step {
    z-index: 2;
    opacity: 1;
    background-color: transparent;
    border-radius: 0;
    align-items: center;
    padding: 5%;
    display: flex;
    position: relative
}

.content-2 {
    margin-top: 24px;
    font-size: 24px;
    font-weight: 500;
    line-height: 1.4
}

.scoll-wrap {
    height: 100%;
    flex-direction: column;
    align-items: center;
    display: flex;
    position: absolute;
    bottom: 50%
}

.dot {
    z-index: 3;
    width: 12px;
    height: 12px;
    background-color: var(--purple-600-light);
    border-radius: 50%;
    margin-top: -5px;
    margin-bottom: -6px;
    position: relative
}

.container-10 {
    width: 100%;
    max-width: 1080px;
    flex-direction: column;
    align-items: flex-start;
    margin-bottom: 10%;
    padding-bottom: 0;
    display: flex;
    position: relative
}

.paragraph-10 {
    font-size: 18px
}

.paragraph-11, .paragraph-12, .paragraph-13 {
    font-size: 20px
}

.thumb-thumb {
    width: 100%;
    height: 2%;
    background-color: var(--purple-600-light);
    color: #000;
    border-radius: 1000px
}

.text-6em {
    color: #000;
    text-transform: none;
    margin: 0;
    font-size: 6em;
    font-weight: 400;
    line-height: .9
}

.dot-2 {
    z-index: 3;
    width: 20px;
    height: 20px;
    background-color: #061c30;
    border: 1px solid #fff;
    border-radius: 2000px;
    position: absolute;
    top: 3%;
    bottom: 0%;
    left: -7px;
    right: 0%
}

.dot-2._98 {
    border-color: var(--purple-600-light);
    background-color: var(--purple-600-light);
    color: var(--purple-600-light);
    -webkit-text-stroke-color: var(--purple-600-light);
    top: 87%
}

.dot-2._6 {
    border-color: var(--purple-600-light);
    background-color: var(--purple-600-light);
    color: var(--purple-600-light);
    top: 60.6%
}

.dot-2._1 {
    border-color: var(--purple-600-light);
    background-color: var(--purple-600-light);
    color: var(--purple-600-light);
    top: -.2%
}

.dot-2._9 {
    top: 96.75%
}

.dot-2._3 {
    top: 26.5%
}

.dot-2._4 {
    border-color: var(--purple-600-light);
    background-color: var(--purple-600-light);
    color: var(--purple-600-light);
    top: 30%
}

.dot-2._5 {
    top: 50.25%
}

.dot-2._2 {
    top: 19%
}

.dot-2._7 {
    top: 73.5%
}

.dot-2._8 {
    border-color: var(--purple-600-light);
    background-color: var(--purple-600-light);
    color: var(--purple-600-light);
    top: 99.6%
}

.text-link {
    color: #fff;
    margin-top: 29px;
    font-size: 1.2em;
    text-decoration: none
}

.text-link.main {
    opacity: 0;
    border: 1px solid red;
    position: absolute
}

.div-block-35 {
    color: red
}

.image-45 {
    width: 100%;
    object-fit: cover
}

.timeline-month {
    color: #000;
    margin-bottom: 7px;
    font-size: 2em;
    font-weight: 700;
    line-height: 25px
}

.gif-image {
    width: 100%;
    height: 250px;
    object-fit: cover;
    object-position: 0% 0%
}

.gif-image._2 {
    height: 270px;
    object-position: 50% 85%
}

.timeline-text {
    max-width: 380px;
    color: #000;
    font-size: 18px;
    line-height: 25px
}

.container-11 {
    width: 100%;
    max-width: 1300px;
    padding-left: 30px;
    padding-right: 30px
}

.container-11.flex-verticle {
    flex-direction: column;
    justify-content: center;
    align-items: center;
    display: flex
}

.confetti {
    z-index: 1;
    display: none;
    position: fixed;
    top: 0%;
    bottom: 0%;
    left: 0%;
    right: 0%;
    transform: scale(1.5)
}

.timeline-item {
    height: 100%;
    text-align: right;
    flex-direction: column;
    justify-content: center;
    align-items: flex-end;
    display: flex;
    overflow: hidden
}

.timeline-item.left-item, .timeline-item.left-2 {
    text-align: left;
    align-items: flex-start
}

.timeline-item._2 {
    height: auto;
    flex-direction: row;
    justify-content: flex-end
}

.timeline-item.right {
    height: 100%
}

.link-30 {
    color: #ee8d32
}

.timeline-content-wrapper {
    width: 44%;
    height: 100%;
    grid-column-gap: 16px;
    grid-row-gap: 40vh;
    grid-template-rows: auto auto;
    grid-template-columns: 1fr;
    grid-auto-columns: 1fr;
    display: grid
}

.text-center {
    text-align: center
}

.text-center.relative {
    cursor: pointer;
    position: relative
}

.timeline-track {
    width: 7px;
    border: 1px solid var(--purple-600-light);
    color: var(--purple-600-light);
    border-radius: 1000px;
    flex-direction: column;
    align-items: stretch;
    display: flex;
    position: relative
}

.new-section {
    color: #333;
    background-color: #fff;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding-top: 100px;
    padding-bottom: 100px;
    display: flex;
    position: relative;
    overflow: hidden
}

.timeline-wrapper {
    width: 90%;
    height: auto;
    max-width: 1000px;
    color: red;
    grid-template-rows: auto auto auto auto auto auto auto auto auto auto auto auto;
    grid-template-columns: 1fr max-content 1fr;
    grid-auto-columns: 1fr;
    align-content: center;
    justify-content: space-between;
    align-items: stretch;
    justify-items: center;
    margin-top: 151px;
    display: flex
}

.paragraph-14 {
    color: #fff;
    text-align: center;
    font-size: 20px;
    line-height: 25px
}

.container-12 {
    text-align: center
}

.div-block-37 {
    display: none
}

.paragraph-15, .paragraph-16 {
    font-size: 20px;
    line-height: 24px
}

.heading-22 {
    text-align: center;
    margin-top: 40px;
    margin-bottom: 20px
}

.paragraph-17 {
    text-align: center;
    margin-bottom: 40px;
    font-size: 20px
}

.div-block-38 {
    height: 300px;
    text-align: center
}

.image-hungryroot {
    align-self: auto;
    position: relative;
    bottom: 10px
}

.section-2 {
    margin-top: 100px;
    margin-bottom: 100px
}

.heading-23 {
    font-size: 40px
}

.heading-24 {
    margin-top: 0;
    margin-bottom: 40px
}

.quick-stack {
    grid-column-gap: 80px;
    grid-row-gap: 40px;
    text-align: left;
    align-self: center;
    padding-left: 0;
    padding-right: 20px
}

.careers-hero {
    background-image: url(https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64ec7c03ec1cda0a0252848d_careers_hero.webp);
    background-position: 50%;
    background-size: cover;
    margin-top: 90px;
    padding-top: 100px;
    padding-bottom: 220px
}

.grid-3-col {
    margin-bottom: 60px
}

.grid-container {
    max-width: 1200px
}

.cell-grey {
    background-color: #f4f4f4;
    border-radius: 8px;
    align-items: center;
    padding-top: 40px;
    padding-bottom: 40px
}

.paragraph-18 {
    color: #fff;
    font-size: 24px;
    font-weight: 400;
    line-height: 28px
}

.text-block-29 {
    margin-bottom: 40px
}

.text-block-30 {
    text-align: center;
    margin-top: 20px;
    margin-left: 40px;
    margin-right: 40px;
    font-size: 20px;
    line-height: 24px
}

.heading-25, .heading-26 {
    font-size: 24px
}

.text-block-31 {
    font-size: 16px
}

.quick-stack-2 {
    grid-column-gap: 20px;
    grid-row-gap: 60px;
    padding-left: 0;
    padding-right: 0
}

.quick-stack-2.y-50 {
    grid-column-gap: 50px
}

.quick-stack-3 {
    padding-left: 0;
    padding-right: 0
}

.paragraph-19 {
    margin-bottom: 40px;
    padding-top: 10px;
    font-size: 20px;
    line-height: 24px
}

.text-block-32 {
    font-size: 16px;
    line-height: 24px
}

.gallery-slider {
    border-bottom: 1px solid #e4ebf3;
    padding: 80px 30px;
    position: relative
}

.container-14 {
    width: 100%;
    max-width: 940px;
    margin-left: auto;
    margin-right: auto
}

.gallery-wrapper {
    grid-column-gap: 40px;
    grid-row-gap: 40px;
    grid-template-rows: auto;
    grid-template-columns: 1fr 1fr 1fr;
    grid-auto-columns: 1fr;
    align-items: start;
    display: grid
}

.gallery-block {
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    display: flex
}

.gallery-slide {
    height: auto;
    background-color: transparent
}

.gallery-slide-wrapper {
    max-width: 47%;
    margin-right: 6%
}

.gallery-slide-image {
    position: relative
}

.gallery-image {
    width: 100%
}

.gallery-slide-text {
    color: #f5f7fa;
    margin-bottom: 0;
    line-height: 32px;
    position: absolute;
    bottom: 24px;
    left: 24px;
    right: 24px
}

.gallery-slider-left {
    width: 40px;
    justify-content: center;
    align-items: center;
    display: flex;
    left: -50px
}

.gallery-slider-left:focus-visible {
    outline-offset: 0px;
    border-radius: 5px;
    outline: 2px solid #0050bd
}

.gallery-slider-left[data-wf-focus-visible] {
    outline-offset: 0px;
    border-radius: 5px;
    outline: 2px solid #0050bd
}

.slider-arrow-embed {
    color: #1a1b1f
}

.gallery-slider-right {
    width: 40px;
    justify-content: center;
    align-items: center;
    display: flex;
    right: -50px
}

.gallery-slider-right:focus-visible {
    outline-offset: 0px;
    border-radius: 5px;
    outline: 2px solid #0050bd
}

.gallery-slider-right[data-wf-focus-visible] {
    outline-offset: 0px;
    border-radius: 5px;
    outline: 2px solid #0050bd
}

.gallery-slide-nav {
    display: none
}

.gallerywrapper {
    background-color: transparent;
    flex: none;
    padding-top: 60px;
    padding-bottom: 40px;
    overflow: visible
}

.carousel {
    flex-direction: column;
    align-items: center;
    display: flex
}

.image-wrapper {
    max-height: 400px;
    opacity: .6;
    margin-right: 5px;
    padding: 1vh 5px;
    transition: opacity .2s;
    display: flex
}

.image-wrapper.slick-center {
    opacity: 1
}

.image {
    max-height: 76vh;
    object-fit: contain;
    border-radius: 14px
}

.carousel-text-container {
    max-width: 1200px;
    margin-bottom: 40px
}

.heading-27 {
    font-size: 40px;
    font-weight: 700;
    line-height: 50px
}

.text-block-33 {
    font-size: 20px;
    line-height: 25px
}

.grid-2-col-30-70 {
    margin-top: 40px
}

.quick-stack-4 {
    padding-left: 0;
    padding-right: 0
}

.image-46 {
    background-color: #170032
}

.main {
    padding-top: 65px;
    padding-bottom: 65px;
    display: none
}

.loading-container {
    opacity: 1;
    transition: opacity .2s
}

.lottie-loading-animation {
    width: 50%;
    margin-left: auto;
    margin-right: auto
}

.root {
    opacity: 0;
    transition: opacity .2s
}

.container-15 {
    max-width: 1200px;
    margin-left: auto;
    margin-right: auto;
    padding-left: 20px;
    padding-right: 20px
}

.form-block {
    max-width: 400px
}

.submit-button, .hidden {
    display: none
}

.department-section {
    padding-top: 60px;
    padding-bottom: 60px
}

.container-16 {
    max-width: 1200px;
    margin-left: auto;
    margin-right: auto;
    padding-left: 20px;
    padding-right: 20px
}

.section-3 {
    padding-top: 60px;
    padding-bottom: 60px
}

.container-17 {
    max-width: 1200px;
    margin-left: auto;
    margin-right: auto;
    padding-left: 20px;
    padding-right: 20px
}

.job-listing {
    border-bottom: 1px solid #e9e9e9;
    margin-bottom: 15px;
    padding-bottom: 15px;
    display: flex
}

.flex-left {
    width: 50%;
    padding-right: 40px
}

.job-title {
    color: #3b3b3b;
    font-size: 1.2rem;
    font-weight: 700;
    text-decoration: none
}

.job-title:hover {
    color: #0076d1
}

.flex-right {
    width: 50%
}

.job-location {
    padding-right: 40px;
    font-size: 1.2rem
}

.container-18 {
    max-width: 1200px
}

.link-block-3 {
    color: #333;
    text-decoration: none
}

.heading-28 {
    color: var(--purple-600-light);
    font-size: 12px
}

.heading-28.light-green {
    color: #05c1b7
}

.heading-29 {
    font-size: 40px
}

.paragraph-20 {
    font-size: 20px;
    line-height: 26px
}

.paragraph-20.white-text {
    margin-top: 20px;
    font-weight: 400
}

.section-dark-bg {
    background-color: var(--purple-1000-dark);
    margin-bottom: 60px
}

.section-dark-bg.my-90.py-60 {
    margin-top: 90px;
    margin-bottom: 40px;
    padding-top: 60px;
    padding-bottom: 60px
}

.white-text.heading-52 {
    font-size: 52px
}

.white-text {
    color: #fff
}

.heading-53 {
    font-size: 28px;
    line-height: 30px
}

._1-1 {
    grid-column-gap: 20px
}

.image-47 {
    margin-top: -10px;
    margin-bottom: 0
}

.gallery-slide-2 {
    align-items: center;
    margin-top: 0%;
    display: block
}

.slider-5 {
    width: 100%;
    height: auto;
    background-color: transparent;
    margin-top: 220px;
    position: relative;
    top: 0%;
    overflow: hidden;
    transform: translateY(-50%)
}

.mask-4 {
    width: 50%;
    text-align: center;
    margin-left: auto;
    margin-right: auto;
    display: block;
    overflow: visible
}

.slide-4 {
    width: 100%;
    text-align: center;
    cursor: grab
}

.left-arrow-2 {
    width: 25%;
    background-image: linear-gradient(90deg, #000, transparent)
}

.right-arrow-2 {
    width: 25%;
    background-image: linear-gradient(270deg, #000, transparent)
}

.slide-nav-4 {
    margin-top: 0;
    font-size: 9px;
    line-height: 20px
}

.image-slider {
    max-height: 400px;
    border-radius: 12px
}

.heading-55 {
    margin-top: 0;
    font-size: 40px;
    font-weight: 700
}

.team-circles {
    background-color: #f8f8ff;
    border-bottom: 1px solid #e4ebf3;
    padding: 80px 30px;
    font-family: Mulish, sans-serif;
    position: relative
}

.container-19 {
    width: 100%;
    max-width: 940px;
    margin-left: auto;
    margin-right: auto
}

.centered-heading {
    text-align: center;
    margin-bottom: 16px
}

.centered-subheading {
    max-width: 530px;
    text-align: center;
    margin-left: auto;
    margin-right: auto
}

.team-grid {
    grid-column-gap: 64px;
    grid-row-gap: 56px;
    grid-template-rows: auto auto;
    grid-template-columns: 1fr 1fr 1fr;
    grid-auto-columns: 1fr;
    margin-top: 50px;
    display: grid
}

.team-card {
    text-align: center;
    flex-direction: column;
    align-items: center;
    font-size: 14px;
    line-height: 22px;
    display: flex
}

.team-member-image {
    width: 270px;
    height: 270px;
    object-fit: cover;
    border-radius: 50%;
    margin-bottom: 24px
}

.team-member-name {
    margin-bottom: 6px;
    font-size: 20px;
    font-weight: 500;
    line-height: 32px
}

.team-member-position {
    margin-bottom: 24px
}

.navbar-logo-left-container {
    z-index: 5;
    width: 1030px;
    max-width: 100%;
    background-color: transparent;
    margin-left: auto;
    margin-right: auto;
    padding: 15px 20px
}

.navbar-logo-left-container.shadow-three {
    width: 100%;
    max-width: 1140px;
    margin-bottom: 0;
    padding-top: 20px;
    padding-bottom: 20px
}

.navbar-wrapper {
    justify-content: space-between;
    align-items: center;
    display: flex
}

.nav-menu-two {
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0;
    display: flex
}

.nav-link-4 {
    color: #1a1b1f;
    letter-spacing: .25px;
    margin-left: 5px;
    margin-right: 5px;
    padding: 5px 10px;
    font-size: 14px;
    line-height: 20px;
    text-decoration: none
}

.nav-link-4:hover {
    color: rgba(26, 27, 31, .75)
}

.nav-link-4:focus-visible {
    outline-offset: 0px;
    color: #0050bd;
    border-radius: 4px;
    outline: 2px solid #0050bd
}

.nav-link-4[data-wf-focus-visible] {
    outline-offset: 0px;
    color: #0050bd;
    border-radius: 4px;
    outline: 2px solid #0050bd
}

.nav-dropdown {
    margin-left: 5px;
    margin-right: 5px
}

.nav-dropdown-toggle {
    letter-spacing: .25px;
    padding: 5px 30px 5px 10px;
    font-size: 14px;
    line-height: 20px
}

.nav-dropdown-toggle:hover {
    color: rgba(26, 27, 31, .75)
}

.nav-dropdown-toggle:focus-visible {
    outline-offset: 0px;
    color: #0050bd;
    border-radius: 5px;
    outline: 2px solid #0050bd
}

.nav-dropdown-toggle[data-wf-focus-visible] {
    outline-offset: 0px;
    color: #0050bd;
    border-radius: 5px;
    outline: 2px solid #0050bd
}

.nav-dropdown-icon {
    margin-right: 10px
}

.nav-dropdown-list {
    background-color: #fff;
    border-radius: 12px
}

.nav-dropdown-list.w--open {
    padding-top: 10px;
    padding-bottom: 10px
}

.nav-dropdown-link {
    padding-top: 5px;
    padding-bottom: 5px;
    font-size: 14px
}

.nav-dropdown-link:focus-visible {
    outline-offset: 0px;
    color: #0050bd;
    border-radius: 5px;
    outline: 2px solid #0050bd
}

.nav-dropdown-link[data-wf-focus-visible] {
    outline-offset: 0px;
    color: #0050bd;
    border-radius: 5px;
    outline: 2px solid #0050bd
}

.nav-divider {
    width: 1px;
    height: 22px;
    background-color: #e4ebf3;
    margin-left: 15px;
    margin-right: 15px
}

.nav-link-accent {
    color: #1a1b1f;
    letter-spacing: .25px;
    margin-left: 5px;
    margin-right: 20px;
    padding: 5px 10px;
    font-size: 14px;
    font-weight: 700;
    line-height: 20px;
    text-decoration: none
}

.nav-link-accent:hover {
    color: rgba(26, 27, 31, .75)
}

.button-primary {
    color: #fff;
    letter-spacing: 2px;
    text-transform: uppercase;
    background-color: #1a1b1f;
    padding: 12px 25px;
    font-size: 12px;
    line-height: 20px;
    transition: all .2s
}

.button-primary:hover {
    color: #fff;
    background-color: #32343a
}

.button-primary:active {
    background-color: #43464d
}
.review-card{
    width: 100%;
    height: 100%;
    object-fit: cover;
    border: 2px solid #e7e7e7;
    border-radius: 20px;
    filter: drop-shadow(0px 4px 4px rgba(194, 194, 194, 0.25));
}
.review-card img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 20px;
    background:  #fff !important;
}
.why-choose{
    display: flex;
    margin: 50px 0px;
    }
    .why-choose ul:nth-child(2) {
       border-left:1px solid #ccc;
     }
     .why-choose ul:nth-child(1) {
    padding-right:20px ;
      }
@media screen and (min-width:1440px) {
    .content.footer {
        grid-column-gap: 18px;
        grid-row-gap: 18px;
        grid-template-rows: auto;
        grid-template-columns: minmax(200px, .25fr) minmax(200px, 1fr) minmax(280px, .25fr) 1fr 1.5fr;
        grid-auto-columns: 1fr;
        grid-auto-flow: row;
        display: grid
    }

    .content.feature.sky {
        grid-column-gap: 0px;
        grid-row-gap: 0px
    }

    .panel-text {
        max-width: 980px
    }

    .solid-button.content {
        z-index: 9;
        display: flex;
        position: relative;
        overflow: visible
    }

    .top-navigation-wrapper:hover {
        background-color: rgba(255, 255, 255, .01)
    }

    .menu-sections {
        margin-left: 407px
    }

    .product-menu-wrapper.menu_dropdown_content {
        display: none
    }

    .ticker {
        overflow: hidden
    }

    .panel-heading.informal {
        font-family: Mulish, sans-serif
    }

    .panel-heading.wide.heading-long {
        min-width: 1000px
    }

    .hero-image {
        display: none
    }

    .panel-paragraph.left.center.wide {
        min-width: 900px
    }

    .footer-links {
        grid-column-gap: 40px;
        grid-row-gap: 16px;
        grid-template-rows: auto;
        grid-template-columns: 1fr 2.25fr 1fr 1fr;
        grid-auto-columns: 1fr;
        grid-auto-flow: row;
        display: grid
    }

    .text-block {
        font-size: 16px
    }

    .logo {
        width: 160px;
        justify-content: center;
        margin-left: 20px;
        margin-right: 20px;
        top: 190px
    }

    .tooltiptext {
        display: block
    }

    .heading {
        overflow: visible
    }

    .heading-2 {
        display: block
    }

    .vp1_t2, .vp1_t3 {
        display: none
    }

    .vp3_t1 {
        display: block
    }

    .vp3_t2, .vp3_t3 {
        display: none
    }

    .button.solid-button.cta.button-oultine {
        width: auto;
        margin-top: 0
    }

    .pop-up-wrapper {
        opacity: 0;
        display: none
    }

    .panel-subheading.informal {
        font-family: Mulish, sans-serif
    }

    .div-block-13 {
        margin-top: 15vh
    }

    .mobile-navbar {
        background-color: #fff
    }

    .panel-subheading-step.informal {
        font-family: Mulish, sans-serif
    }

    .package-description {
        text-align: center;
        overflow: visible
    }

    .package-top {
        height: auto;
        min-height: 450px
    }

    .package-includes {
        margin-top: 20px
    }

    .dropdown-list.w--open {
        justify-content: space-around;
        display: flex
    }

    .dropdown-3 {
        margin-right: -8%
    }

    .menu-wrapper {
        justify-content: space-around;
        padding-left: 80px;
        padding-right: 80px;
        position: fixed;
        left: 0%
    }

    .image-26, .image-27 {
        width: auto;
        height: 40px
    }

    .image-28, .image-29, .image-30 {
        height: 40px
    }

    .image-36 {
        height: 60px;
        margin-top: -10px
    }

    .image-37, .image-38 {
        height: 50px;
        margin-top: -10px
    }

    .image-39 {
        padding-top: 9px
    }

    .image-40 {
        padding-top: 2px
    }

    .image-41 {
        padding-top: 9px
    }

    .top-a {
        min-height: 250px
    }

    .icon-3 {
        -webkit-text-stroke-color: var(--black)
    }

    .icon-3:hover {
        -webkit-text-stroke-color: var(--purple-600-light);
        border: 1px transparent
    }

    .paragraph-3 {
        display: block
    }

    .link-2 {
        opacity: .98
    }

    .link-3, .link-4, .link-5 {
        opacity: 0
    }

    .link-6, .link-7 {
        opacity: 1
    }

    .link-8, .link-9, .link-10, .link-11, .link-12 {
        opacity: 0
    }

    .link-13, .link-14 {
        opacity: .12
    }

    .link-15 {
        opacity: 1
    }

    .link-16 {
        opacity: .85
    }

    .link-17, .link-18, .link-19 {
        opacity: .23
    }

    .link-20 {
        opacity: .93
    }

    .link-21, .link-22, .link-23, .link-24 {
        opacity: 1
    }

    .heading-5 {
        margin-top: 0;
        font-size: 16px;
        line-height: 20px
    }

    .bold-text-2 {
        font-size: 16px;
        line-height: 20px
    }

    .list-item, .list-item-2, .list-item-3 {
        font-size: 16px
    }

    .link-25 {
        color: var(--black);
        text-decoration: none
    }

    .link-25:hover {
        color: var(--purple-600-light)
    }

    .heading-6, .heading-7, .heading-8, .heading-9 {
        margin-top: 0;
        font-size: 16px;
        line-height: 20px
    }

    .logos {
        grid-column-gap: 50px;
        grid-row-gap: 50px;
        margin-top: 40px;
        display: flex
    }

    .aside {
        flex-direction: column;
        flex: none;
        order: 0;
        margin-right: 60px;
        padding-top: 15px;
        display: flex
    }

    .text-block-23 {
        flex-direction: column;
        flex: 0 auto;
        order: 0;
        display: block
    }

    .heading-11 {
        font-size: 20px
    }

    .line-height-30 {
        -webkit-text-stroke-color: var(--black);
        line-height: 30px
    }

    .heading-12 {
        font-size: 16px
    }

    .heading-13 {
        font-size: 18px;
        font-weight: 600
    }

    .link-26 {
        color: var(--black);
        font-size: 20px;
        line-height: 22px;
        text-decoration: none
    }

    .link-26:hover {
        font-weight: 400
    }

    .breadcrumb-item {
        padding-top: 10px
    }

    .breadcrumb-item:hover {
        color: var(--black);
        font-weight: 600;
        text-decoration: underline
    }

    .logo_component-slider {
        overflow: visible
    }

    .image-43 {
        height: 30px
    }

    .image-44 {
        height: 36px
    }

    .legal-text-container {
        margin-top: 40px;
        margin-bottom: 0
    }

    .bold-text-4 {
        color: var(--black)
    }

    .text-span-4 {
        color: #000
    }

    .bold-text-5 {
        -webkit-text-stroke-color: var(--black)
    }

    .section-gradient {
        padding-top: 100px;
        padding-bottom: 100px
    }

    .card-grey-bg {
        grid-column-gap: 20px;
        flex: 1;
        margin-right: 0
    }

    .container-9 {
        grid-column-gap: 20px;
        flex-direction: row;
        justify-content: space-around;
        align-items: flex-start
    }

    .section-cards {
        justify-content: space-between;
        margin-top: 60px;
        display: block
    }

    .div-block-32 {
        flex: 1;
        align-self: flex-start
    }

    .paragraph-4 {
        font-size: 20px;
        line-height: 23px
    }

    .heading-16 {
        font-size: 40px
    }

    .list-container {
        text-align: left;
        flex-direction: column;
        align-items: center;
        padding-left: 20px;
        padding-right: 20px;
        display: flex
    }

    .heading-17 {
        grid-column-gap: 20px;
        color: #662abc;
        font-family: ivypresto-display, sans-serif;
        font-size: 100px;
        line-height: 120px;
        display: flex
    }

    .heading-purple {
        color: #662abc;
        font-family: ivypresto-display, sans-serif
    }

    .heading-purple.blue {
        color: #0c7fd0
    }

    .heading-purple.teal {
        color: #009b93;
        -webkit-text-stroke-color: #009b93
    }

    .heading-purple.orange {
        color: #ef4e1d
    }

    .heading-purple.fuschia {
        color: #be3aa7;
        -webkit-text-stroke-color: #be3aa7
    }

    .heading-19, .heading-20 {
        display: flex
    }

    .heading-ivy {
        width: 70px;
        font-size: 80px;
        line-height: 140px;
        display: flex
    }

    .heading-ivy.blue {
        color: #0c7fd0
    }

    .heading-ivy.teal {
        color: #009b93
    }

    .heading-ivy.orange {
        color: #ef4e1d;
        justify-content: center
    }

    .heading-ivy.fuschia {
        color: #be3aa7;
        justify-content: center
    }

    .heading-ivy.red {
        justify-content: center
    }

    .listi-item-about-us {
        width: 680px;
        text-align: left;
        justify-content: center;
        align-items: center;
        display: flex
    }

    .div-block-34 {
        margin-left: 40px
    }

    .paragraph-5 {
        font-size: 20px;
        line-height: 24px
    }

    .paragraph-6, .paragraph-7 {
        font-size: 20px
    }

    .paragraph-8 {
        line-height: 32px
    }

    .paragraph-9 {
        line-height: 24px
    }

    .text-about-us-list {
        font-size: 20px;
        line-height: 24px
    }

    .label {
        font-size: 100px;
        line-height: 120px
    }

    .timeline-section {
        display: none
    }

    .heading-21 {
        font-size: 24px;
        line-height: 28px
    }

    .thumb-thumb {
        border: 1px solid var(--purple-600-light)
    }

    .text-6em {
        font-size: 40px;
        font-weight: 700;
        line-height: 50px
    }

    .dot-2._98 {
        border-color: var(--purple-600-light);
        cursor: default;
        top: 99.8%
    }

    .dot-2._6 {
        top: 58%
    }

    .dot-2._1 {
        color: var(--purple-600-light);
        top: -.4%
    }

    .dot-2._4 {
        top: 30%
    }

    .dot-2._8 {
        background-color: var(--purple-600-light);
        top: 86%
    }

    .gif-image.right {
        height: auto;
        color: transparent;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, .2), 0 0 11px -6px rgba(0, 0, 0, .2)
    }

    .gif-image.left {
        height: auto
    }

    .timeline-item {
        height: 400px;
        justify-content: flex-start
    }

    .timeline-item.left-item {
        height: 400px;
        display: block
    }

    .timeline-item.right {
        height: 400px
    }

    .timeline-content-wrapper {
        grid-row-gap: 40vh
    }

    .timeline-track {
        border-color: var(--purple-600-light);
        color: var(--black);
        -webkit-text-stroke-color: var(--purple-600-light)
    }

    .new-section {
        padding-bottom: 39px
    }

    .timeline-wrapper {
        top: 73%
    }

    .paragraph-14 {
        color: #fff;
        text-align: center;
        font-size: 20px;
        display: block
    }

    .container-12 {
        text-align: center
    }

    .paragraph-15, .paragraph-16 {
        font-size: 20px;
        line-height: 24px
    }

    .container-13 {
        text-align: center
    }

    .main {
        display: none
    }

    .slider-5 {
        overflow: hidden
    }

    .team-member-image {
        width: 270px;
        height: 270px;
        max-height: none
    }
}

@media screen and (min-width:1920px) {
    .body {
        overflow: visible
    }

    .wrapper {
        overflow: hidden
    }

    .content-panel-hero.background-gradient-light.home, .content-panel-usp1, .content-panel-usp2 {
        min-height: auto
    }

    .heading-ivy, .heading-ivy.blue, .heading-ivy.teal {
        font-size: 80px
    }

    .slider-5 {
        overflow: hidden
    }
}

@media screen and (max-width:991px) {
    .grid-2-col.careers-hero {
        padding-top: 60px
    }

    .grid-2-col.careers-hero.background_purple-100 {
        padding-left: 36px;
        padding-right: 36px
    }

    .grid-2-col.careers-hero.purple-100.pricing {
        padding-left: 30px;
        padding-right: 30px
    }

    .grid-2-col.feature {
        padding: 30px
    }

    .grid-2-col.feature.background_purple-100 {
        padding-left: 36px;
        padding-right: 36px
    }

    .grid-2-col.feature.last {
        padding-bottom: 60px
    }

    .grid-2-col.pricing {
        padding-left: 30px;
        padding-right: 30px
    }

    .content.flush-left.hero {
        flex-direction: column-reverse;
        order: 0;
        align-items: center
    }

    .content.footer {
        grid-column-gap: 9px;
        grid-row-gap: 9px;
        grid-template-columns: 1fr .5fr .75fr
    }

    .content.side-image {
        justify-content: flex-start;
        align-items: flex-end
    }

    .content.kpis {
        grid-column-gap: 30px;
        grid-row-gap: 30px
    }

    .content.feature {
        padding: 45px
    }

    .content.feature.sky {
        grid-column-gap: 0px;
        grid-row-gap: 0px
    }

    .content.feature.candy.outline.flip {
        justify-content: flex-end;
        padding-left: 0
    }

    .content.feature.outline {
        align-items: flex-end
    }

    .content.feature.outline.flip {
        flex-direction: row;
        padding-left: 45px
    }

    .content.infographic {
        height: auto
    }

    .panel-text {
        grid-column-gap: 14px;
        grid-row-gap: 14px;
        flex-wrap: nowrap;
        font-size: 16px;
        line-height: 25px
    }

    .panel-text.centered {
        width: 95%;
        max-width: 980px
    }

    .panel-text.side-by-side {
        max-width: 80%;
        align-items: center;
        padding-top: 0;
        padding-bottom: 40px
    }

    .panel-text.left.step {
        width: 75%
    }

    .panel-text.kpis {
        width: 90%
    }

    .panel-text.feature.flip.outline {
        padding-left: 0;
        padding-right: 20px
    }

    .panel-text.feature.outline {
        padding-right: 20px
    }

    .top-navigation-wrapper {
        display: none
    }

    .panel-heading {
        min-width: auto;
        font-size: 48px;
        line-height: 56px
    }

    .panel-heading.informal {
        font-family: Mulish, sans-serif
    }

    .panel-heading.heading-long {
        min-width: auto
    }

    .panel-heading.center.hero, .panel-paragraph {
        text-align: center
    }

    .panel-paragraph.center {
        font-size: 18px;
        line-height: 28px
    }

    .panel-visual-dashboard {
        min-height: auto;
        grid-column-gap: 10px;
        grid-row-gap: 10px;
        flex-direction: column;
        align-items: center;
        margin-top: 40px
    }

    .panel-visual-dashboard.cards {
        flex-flow: wrap;
        align-content: center;
        justify-content: center;
        align-items: stretch
    }

    .panel-visual-dashboard.logos {
        flex-direction: row
    }

    .panel-info-card {
        width: 100%
    }

    .info-card-title {
        font-size: 30px;
        line-height: 35px
    }

    .info-card-description {
        font-size: 18px;
        line-height: 22px
    }

    .info-card-subtitle {
        font-size: 16px;
        line-height: 19px
    }

    .footer-link {
        max-height: none;
        max-width: 100px;
        line-height: 20px
    }

    .footer-links {
        grid-column-gap: 70px;
        grid-row-gap: 70px;
        grid-template-rows: auto auto;
        grid-template-columns: 1fr 1fr;
        grid-auto-columns: 1fr;
        display: grid
    }

    .footer-legal-social {
        margin-top: 80px
    }

    .vp_visualframe {
        transform: none
    }

    .vp_captionframe {
        width: 100%;
        grid-column-gap: 22px;
        grid-row-gap: 22px;
        margin-top: 60px;
        padding-bottom: 0;
        padding-left: 40px;
        padding-right: 40px
    }

    .heading-2 {
        font-size: 20px;
        line-height: 23px
    }

    .heading-2.caption, .heading-2.ranking {
        font-size: 24px;
        line-height: 28px
    }

    .vp1_as2 {
        grid-column-gap: 5px;
        grid-row-gap: 5px
    }

    .alsosee {
        font-size: 18px;
        line-height: 22px
    }

    .alsosee-wrapper {
        grid-column-gap: 11px;
        grid-row-gap: 11px
    }

    .screendotsframe {
        height: 30px
    }

    .image-15 {
        width: 100%
    }

    .dashboard-modules-wrapper {
        width: 85.0639%;
        position: absolute
    }

    .vp1_t1 {
        text-align: center
    }

    .content-panel-footer.no-min-height {
        padding: 40px 36px
    }

    .content-panel-hero.background-gradient-light.home {
        min-height: auto;
        padding-top: 0
    }

    .content-panel-usp1 {
        padding: 80px 36px
    }

    .content-panel-usp2 {
        padding: 80px 36px 60px
    }

    .content-panel-usp3 {
        padding: 60px 36px
    }

    .caption-paragraph {
        font-size: 16px;
        line-height: 20px
    }

    .image-19, .image-20, .image-21 {
        width: 36px
    }

    .panel-visual-modules {
        min-height: auto;
        grid-column-gap: 10px;
        grid-row-gap: 10px;
        flex-direction: column;
        align-items: center;
        margin-top: 40px
    }

    .vp2_c-1 {
        width: 100%;
        grid-column-gap: 22px;
        grid-row-gap: 22px;
        padding-bottom: 0;
        padding-left: 40px;
        padding-right: 40px
    }

    .vp2_c-2 {
        width: 100%;
        grid-column-gap: 22px;
        grid-row-gap: 22px;
        align-items: flex-start;
        padding-bottom: 0;
        padding-left: 40px;
        padding-right: 40px
    }

    .vp2_c-3 {
        width: 100%;
        grid-column-gap: 22px;
        grid-row-gap: 22px;
        padding-bottom: 0;
        padding-left: 40px;
        padding-right: 40px
    }

    .slider-3 {
        height: 24vh
    }

    .moddotframe {
        height: 30px
    }

    .vp3_as2 {
        grid-column-gap: 5px;
        grid-row-gap: 5px
    }

    .button {
        margin-bottom: 20px
    }

    .button.solid-button {
        margin-top: 40px
    }

    .button.solid-button.cta.button-oultine {
        width: 100%;
        flex-direction: row;
        padding-left: 10px;
        padding-right: 10px
    }

    .button.solid-button {
        margin-top: 40px
    }

    .button.solid-button.btn-mbl {
        margin-left: 20px
    }

    .button.button-solid {
        min-height: 56px
    }

    .button.button-outline {
        width: 100%;
        min-height: 56px;
        justify-content: center;
        align-self: auto;
        align-items: center;
        padding-left: 10px;
        padding-right: 10px;
        display: flex
    }

    .kpi-modules {
        grid-template-columns: 1fr 1fr
    }

    .kpi-overlays {
        z-index: 50
    }

    .kpi-overlay {
        grid-column-gap: 60px;
        grid-row-gap: 60px;
        padding: 0 10px 40px 40px;
        display: block;
        overflow: scroll
    }

    .kpi-heading-h2 {
        font-size: 48px;
        line-height: 50px
    }

    .kpi-overlay-details {
        grid-column-gap: 30px;
        grid-row-gap: 30px
    }

    .close {
        z-index: 100
    }

    .panel-subheading.informal {
        width: 100%;
        font-family: Mulish, sans-serif
    }

    .panel-subheading.feature {
        font-size: 30px;
        line-height: 35px
    }

    .panel-visual {
        width: 40%;
        margin-left: 40px
    }

    .panel-visual.feature.outline {
        width: 50%;
        margin-top: 0
    }

    .content-panel-story.first.background_purple-100 {
        padding-left: 36px;
        padding-right: 36px
    }

    .content-panel-story.first.grandient.informal {
        padding-top: 120px
    }

    .content-panel-story.varheight, .content-panel-story.varheight-2 {
        align-items: flex-start;
        padding: 70px 40px;
        display: flex;
        position: relative
    }

    .caption-text {
        padding-left: 5%;
        padding-right: 5%;
        font-size: 14px;
        line-height: 18px
    }

    .caption-text.usecase {
        padding-top: 5px
    }

    .dropdown-list-2, .nav-menu {
        background-color: #fff
    }

    .menu-button {
        background-color: transparent
    }

    .mobile-navbar {
        width: 100%;
        display: block
    }

    .dropdown, .dropdown-2 {
        background-color: #fff
    }

    .nav-link {
        background-color: #fff;
        font-size: 14px;
        font-weight: 700
    }

    .nav-link-2 {
        background-color: #fff;
        font-weight: 700
    }

    .nav-link-3 {
        background-color: #fff;
        font-size: 14px;
        font-weight: 700
    }

    .image-24 {
        width: 100%
    }

    .extraspace {
        max-width: 100%
    }

    .extraspace.two {
        max-width: 90%
    }

    .screen {
        max-width: 100%
    }

    .pricing-package {
        padding-left: 20px;
        padding-right: 20px
    }

    .pricing-packages {
        grid-column-gap: 15px;
        grid-row-gap: 15px;
        justify-content: center;
        padding-left: 0;
        padding-right: 0
    }

    .package-description {
        margin-bottom: 20px;
        font-size: 16px;
        line-height: 23px
    }

    .package-price {
        font-size: 24px
    }

    .package-top {
        border-bottom-width: 0;
        justify-content: space-between
    }

    .button-oultine {
        width: 100%;
        justify-content: center;
        padding-left: 15px;
        padding-right: 15px;
        font-size: 16px
    }

    .button-solid {
        width: 100%;
        justify-content: center;
        padding-left: 10px;
        padding-right: 10px;
        font-size: 16px
    }

    .package-includes {
        flex: 0 auto
    }

    .pricing-bullet-text {
        font-size: 16px;
        line-height: 21px
    }

    .pricingtable-c1 {
        width: 30%
    }

    .pricingtable {
        width: 100%
    }

    .pricingtable-textrow {
        height: 65px
    }

    .pricingtable-txt {
        font-size: 18px
    }

    .pricingtable-c2 {
        width: 25%
    }

    .faqs {
        width: 100%
    }

    .text-block-16, .text-block-17, .text-block-18 {
        font-size: 16px;
        line-height: 23px
    }

    .navbar-navitems, .vp1-slider {
        width: 100%
    }

    .right-arrow.extra {
        margin-right: 15px
    }

    .flex-block {
        text-align: center;
        align-items: center
    }

    .text-block-20, .text-block-21 {
        font-size: 14px;
        font-weight: 700
    }

    .div-block-29 {
        width: 40%;
        grid-column-gap: 10px;
        grid-row-gap: 10px
    }

    .panel-visual-modules-full {
        min-height: auto;
        grid-column-gap: 10px;
        grid-row-gap: 10px;
        flex-direction: column;
        align-items: center;
        margin-top: 40px
    }

    .slider-4 {
        width: 90%
    }

    .slidetext.ranking {
        margin-left: 57px
    }

    .vp2-screentitle {
        grid-column-gap: 15px;
        grid-row-gap: 15px
    }

    .cirlcenumber {
        width: 42px;
        height: 42px
    }

    .text-block-22 {
        font-size: 24px;
        line-height: 24px
    }

    .top-a {
        min-height: 260px
    }

    .top-b {
        min-height: 0;
        flex: 1;
        padding-bottom: 0;
        position: static
    }

    .aside {
        display: none
    }

    .container-8 {
        margin-left: 20px;
        margin-right: 20px
    }

    .page-padding.s0 {
        margin-top: 2rem;
        margin-bottom: 2rem
    }

    .padding-vertical {
        padding-left: 0;
        padding-right: 0
    }

    .logo_component-slider {
        grid-column-gap: 3rem
    }

    .logo-slider-img {
        width: 174px
    }

    .logo_component-slider-2 {
        grid-column-gap: 3rem
    }

    .text-6em {
        font-size: 4.5em
    }

    .gif-image.right {
        height: auto
    }

    .timeline-text {
        max-width: 700px;
        padding-bottom: 20px
    }

    .timeline-wrapper {
        display: none
    }

    .div-block-36 {
        text-align: center;
        padding-top: 20px
    }

    .div-block-37 {
        display: block
    }

    .container-14 {
        max-width: 728px
    }

    .gallery-wrapper {
        grid-template-columns: 1fr 1fr
    }

    .gallery-slider-left {
        left: -20px
    }

    .gallery-slider-right {
        right: -20px
    }

    .container-19 {
        max-width: 728px
    }

    .team-grid {
        grid-column-gap: 40px
    }

    .team-member-image {
        width: 190px;
        height: 190px
    }

    .nav-menu-wrapper {
        background-color: transparent
    }

    .nav-menu-two {
        background-color: #fff;
        border-radius: 50px;
        flex-wrap: wrap;
        justify-content: space-around;
        align-items: center;
        margin-top: 10px;
        padding: 20px;
        display: flex;
        box-shadow: 0 8px 50px rgba(0, 0, 0, .05)
    }

    .nav-link-4 {
        padding-left: 5px;
        padding-right: 5px
    }

    .nav-dropdown-list.shadow-three.w--open {
        position: absolute
    }

    .menu-button-2 {
        padding: 12px
    }

    .menu-button-2.w--open {
        color: #fff;
        background-color: #a6b1bf
    }
}

@media screen and (max-width:767px) {
    .grid-2-col.careers-hero.background_purple-100 {
        padding-left: 24px;
        padding-right: 24px
    }

    .grid-2-col.feature {
        padding: 20px
    }

    .grid-2-col.feature.background_purple-100 {
        padding-left: 24px;
        padding-right: 24px
    }

    .grid-2-col.feature.last {
        padding-bottom: 40px
    }

    .content.footer {
        display: flex
    }

    .content.side-image {
        flex-direction: column
    }

    .content.feature {
        padding: 30px
    }

    .content.feature.wine {
        flex-direction: column
    }

    .content.feature.sky {
        grid-column-gap: 0px;
        grid-row-gap: 0px;
        flex-direction: column
    }

    .content.feature.grass, .content.feature.candy, .content.feature.emerald, .content.feature.peacock, .content.feature.outline {
        flex-direction: column
    }

    .content.feature.outline.flip {
        flex-direction: column;
        padding-left: 30px
    }

    .content.infographic {
        flex-direction: column
    }

    .content.infographic.swap {
        flex-direction: column-reverse
    }

    .panel-text.left {
        width: 100%
    }

    .panel-text.left.inforgraphic {
        width: 100%;
        order: 1
    }

    .panel-text.left.cloud, .panel-text.left.step, .panel-text.feature.bubbles {
        width: 100%
    }

    .panel-text.feature.flip.outline {
        width: 100%;
        padding-left: 0
    }

    .panel-text.feature.outline {
        width: 100%
    }

    .top-navigation-wrapper {
        display: none
    }

    .panel-heading {
        min-width: auto;
        font-size: 36px;
        line-height: 42px
    }

    .panel-heading.informal {
        font-family: Mulish, sans-serif
    }

    .hero-image {
        display: block
    }

    .centeral-image {
        justify-content: center;
        align-self: center;
        display: flex
    }

    .panel-paragraph.left.center {
        text-align: left
    }

    .panel-visual-dashboard {
        flex-direction: column
    }

    .panel-visual-dashboard.cards {
        align-items: stretch
    }

    .panel-visual-dashboard.logos {
        justify-content: space-around
    }

    .panel-info-card {
        width: 48%
    }

    .info-card-description {
        font-size: 16px
    }

    .footer-heading {
        margin-bottom: 0
    }

    .footer-link {
        max-width: 150px;
        min-width: 150px
    }

    .footer-links {
        grid-column-gap: 0px;
        grid-row-gap: 0px;
        justify-content: space-between
    }

    .footer-legal-social {
        grid-column-gap: 20px;
        grid-row-gap: 20px;
        flex-direction: column;
        margin-top: 40px
    }

    .legal-block {
        text-align: center;
        font-size: 10px;
        line-height: 12px
    }

    .text-block {
        margin-top: 20px;
        margin-bottom: 40px
    }

    .vp_captionframe {
        width: 100%;
        padding-bottom: 0
    }

    .heading-2.caption, .heading-2.ranking {
        font-size: 20px;
        line-height: 23px
    }

    .alsosee-wrapper {
        grid-column-gap: 18px;
        grid-row-gap: 18px
    }

    .content-panel-footer.no-min-height {
        padding-left: 24px;
        padding-right: 24px
    }

    .content-panel-usp1, .content-panel-usp2, .content-panel-usp3 {
        min-height: auto;
        padding: 80px 24px
    }

    .panel-visual-modules {
        flex-direction: column
    }

    .vp2_c-1, .vp2_c-2, .vp2_c-3 {
        width: 100%
    }

    .button.solid-button {
        margin-top: 20px
    }

    .panel-modules.kpis {
        align-self: center
    }

    .kpi-overlay {
        width: 95%;
        max-width: none;
        grid-column-gap: 40px;
        grid-row-gap: 40px;
        display: none;
        left: 2.5%;
        right: 2.5%
    }

    .kpi-overlay.kpi-2, .kpi-overlay.kpi-3, .kpi-overlay.kpi-4, .kpi-overlay.kpi-5, .kpi-overlay.kpi-6, .kpi-overlay.kpi-8, .kpi-overlay.kpi-9 {
        grid-column-gap: 40px;
        grid-row-gap: 40px
    }

    .kpi-icon-large {
        width: 88px;
        height: 88px;
        border-radius: 20px
    }

    .kpi-heading-h2 {
        font-size: 36px;
        line-height: 42px
    }

    .kpi-overlay-details {
        grid-column-gap: 20px;
        grid-row-gap: 20px
    }

    .kpi-bodytext {
        font-size: 16px;
        line-height: 25px
    }

    .kpi-overlay-contentscroll {
        width: auto;
        grid-column-gap: 40px;
        grid-row-gap: 40px;
        display: flex
    }

    .panel-subheading.informal {
        font-family: Mulish, sans-serif
    }

    .panel-subheading.informal.center {
        text-align: left
    }

    .panel-subheading.feature {
        font-size: 24px;
        line-height: 28px
    }

    .panel-visual {
        width: 100%;
        display: flex
    }

    .panel-visual.screen {
        width: 100%
    }

    .panel-visual.screen.wcaption {
        display: flex
    }

    .panel-visual.feature {
        width: 80%;
        align-items: center;
        margin-left: 0;
        padding-top: 20px
    }

    .panel-visual.feature.outline {
        width: 100%
    }

    .panel-visual.infographic {
        width: 100%;
        order: 2;
        padding-top: 0;
        padding-bottom: 40px
    }

    .panel-visual.infographic.extradown {
        width: 100%;
        order: 0;
        margin-bottom: 40px
    }

    .content-panel-story.background-purple100.varheight-2 {
        flex-direction: row
    }

    .content-panel-story.first.background_purple-100 {
        padding-left: 24px;
        padding-right: 24px
    }

    .content-panel-story.first.grandient.informal {
        padding-top: 80px
    }

    .content-panel-story.varheight, .content-panel-story.varheight-2 {
        padding: 70px 30px
    }

    .dropdown-list-2 {
        background-color: #fff
    }

    .nav-menu {
        background-color: #fff;
        padding-bottom: 20px
    }

    .mobile-navbar, .dropdown, .dropdown-2, .container-6, .nav-link, .nav-link-2, .nav-link-3 {
        background-color: #fff
    }

    .image-24 {
        object-fit: fill;
        align-self: flex-start
    }

    .panel-focusarea.purple {
        font-size: 18px
    }

    .toggle {
        min-width: 80px
    }

    .pricing-package {
        width: 100%
    }

    .pricing-packages {
        flex-direction: column
    }

    .package-description {
        height: 80px
    }

    .package-top {
        border-bottom-width: 0
    }

    .pricing-bullet-text.left.center {
        text-align: left
    }

    .question {
        font-size: 20px
    }

    .right-arrow.extra {
        margin-right: 0
    }

    .paragraph, .answer {
        font-size: 16px;
        line-height: 25px
    }

    .html-embed {
        display: none
    }

    .panel-visual-modules-full {
        flex-direction: column
    }

    .slidetext.ranking {
        margin-left: 51px;
        font-size: 16px;
        line-height: 24px
    }

    .cirlcenumber {
        width: 36px;
        height: 36px
    }

    .text-block-22 {
        font-size: 20px;
        line-height: 20px
    }

    .paragraph-2 {
        font-size: 16px;
        line-height: 25px
    }

    .top-a {
        min-height: 150px
    }

    .container-8 {
        flex-direction: column
    }

    .padding-vertical {
        padding-left: 0;
        padding-right: 0
    }

    .logo_component-slider {
        grid-row-gap: 2rem;
        flex-direction: row;
        grid-template-columns: 1fr;
        justify-content: flex-start;
        align-items: center
    }

    .logo-slider-img {
        width: 125px
    }

    .logo_component-slider-2 {
        grid-row-gap: 2rem;
        flex-direction: row;
        grid-template-columns: 1fr;
        justify-content: flex-start;
        align-items: center
    }

    .section-gradient {
        margin-top: 0
    }

    .heading-14 {
        font-size: 30px;
        line-height: 38px
    }

    .card-grey-bg {
        padding-top: 20px;
        padding-bottom: 20px
    }

    .heading-15 {
        font-size: 40px
    }

    .container-9 {
        flex-direction: column
    }

    .section-cards {
        margin-left: 20px;
        margin-right: 10px
    }

    .heading-ivy {
        margin-top: 30px
    }

    .listi-item-about-us {
        width: auto;
        max-width: 400px
    }

    .step-block {
        min-height: 110vh;
        flex-direction: column;
        justify-content: center;
        align-items: center
    }

    .img-block {
        z-index: 3;
        width: 70%;
        min-height: 50vh;
        order: 3;
        padding-top: 20px;
        position: relative
    }

    .content-wrap {
        width: 70%;
        height: 50vh;
        justify-content: center;
        align-items: center;
        padding-bottom: 20px
    }

    .step-content-block {
        z-index: 2;
        order: -1;
        justify-content: center;
        align-items: center;
        display: flex
    }

    .step {
        justify-content: center;
        padding: 8%
    }

    .scoll-wrap {
        z-index: 1;
        height: 100%;
        top: -100%;
        bottom: 0%;
        left: 5%;
        right: auto
    }

    .dot {
        z-index: 99;
        order: 2;
        align-self: center;
        margin-bottom: 0;
        position: absolute;
        bottom: 50%
    }

    .gif-image {
        height: 160px;
        object-position: 50% 50%
    }

    .gif-image.right {
        height: auto
    }

    .timeline-text {
        max-width: 500px;
        padding-bottom: 20px
    }

    .timeline-item {
        height: 270px
    }

    .timeline-content-wrapper {
        width: 45%;
        font-size: 12px
    }

    .timeline-wrapper {
        display: none
    }

    .container-12 {
        padding-bottom: 60px
    }

    .div-block-36 {
        text-align: center;
        margin-top: 20px
    }

    .div-block-37 {
        display: block
    }

    .div-block-38 {
        margin-left: 10px;
        margin-right: 10px
    }

    .quick-stack-2.y-50 {
        padding-left: 20px;
        padding-right: 20px
    }

    .gallery-slider {
        padding: 60px 15px
    }

    .gallery-slide {
        margin-left: 10px;
        margin-right: 10px
    }

    .gallery-slide-text {
        line-height: 30px
    }

    .gallery-slider-left {
        left: -20px
    }

    .gallery-slider-right {
        right: -20px
    }

    .image {
        max-height: 40vh
    }

    .job-listing {
        flex-direction: column
    }

    .flex-left, .flex-right {
        width: 100%
    }

    .team-circles {
        padding: 60px 15px
    }

    .team-grid {
        grid-template-columns: 1fr 1fr
    }

    .navbar-logo-left-container {
        max-width: 100%
    }

    .navbar-brand {
        padding-left: 0
    }

    .nav-menu-two {
        border-radius: 20px;
        flex-direction: column;
        padding-bottom: 30px
    }

    .nav-link-4 {
        padding-top: 10px;
        padding-bottom: 10px;
        display: inline-block
    }

    .nav-dropdown {
        flex-direction: column;
        align-items: center;
        display: flex
    }

    .nav-dropdown-toggle {
        padding-top: 10px;
        padding-bottom: 10px
    }

    .nav-dropdown-list.shadow-three {
        box-shadow: 0 8px 50px rgba(0, 0, 0, .05)
    }

    .nav-dropdown-list.shadow-three.w--open {
        position: relative
    }

    .nav-dropdown-list.shadow-three.mobile-shadow-hide {
        box-shadow: none
    }

    .nav-divider {
        width: 200px;
        height: 1px;
        max-width: 100%;
        margin-top: 10px;
        margin-bottom: 10px
    }

    .nav-link-accent {
        margin-right: 5px;
        padding-top: 10px;
        padding-bottom: 10px;
        display: inline-block
    }

    .mobile-margin-top-10 {
        margin-top: 10px
    }
}

@media screen and (max-width:479px) {
    .why-choose{
        flex-direction: column;
     }
     .why-choose ul:nth-child(2){
        
        border: none;
     }
    .grid-2-col {
        flex-direction: row;
        margin-top: 0;
        padding-top: 60px;
        padding-left: 20px;
        padding-right: 10px;
        display: block
    }

    .grid-2-col.background-purple100.pricing {
        padding-left: 15px;
        padding-right: 15px
    }

    .grid-2-col.careers-hero {
        padding-bottom: 40px;
        padding-left: 20px;
        padding-right: 20px
    }

    .grid-2-col.careers-hero.background_purple-100 {
        padding-top: 120px;
        padding-left: 20px;
        padding-right: 20px
    }

    .grid-2-col.careers-hero.purple-100.pricing {
        margin-top: auto;
        padding-top: 120px;
        padding-left: 15px;
        padding-right: 15px
    }

    .grid-2-col.feature {
        padding: 10px
    }

    .grid-2-col.feature.background_purple-100 {
        padding-top: 120px;
        padding-left: 20px;
        padding-right: 20px
    }

    .grid-2-col.feature.last {
        padding-bottom: 20px
    }

    .grid-2-col.pricing.compare {
        display: none
    }

    .content {
        width: 100%;
        grid-column-gap: 2px;
        grid-row-gap: 2px
    }

    .content.flush-left.hero {
        flex-direction: column;
        margin-top: 100px
    }

    .content.footer {
        grid-column-gap: 9px;
        grid-row-gap: 9px;
        grid-template-rows: auto;
        grid-template-columns: 1fr .5fr .75fr;
        grid-auto-columns: 1fr;
        display: grid
    }

    .content.side-image {
        flex-direction: column
    }

    .content.kpis {
        grid-column-gap: 0px;
        grid-row-gap: 0px
    }

    .content.feature {
        flex-direction: column;
        padding: 20px
    }

    .content.feature.wine {
        flex-direction: column-reverse
    }

    .panel-text {
        grid-column-gap: 12px;
        grid-row-gap: 12px
    }

    .panel-text.centered {
        text-align: center;
        align-items: flex-start;
        margin-bottom: 30px
    }

    .panel-text.centered.pricing {
        margin-bottom: 30px
    }

    .panel-text.centered.vp {
        grid-column-gap: 0px;
        grid-row-gap: 0px
    }

    .panel-text.side-by-side {
        max-width: 100%
    }

    .panel-text.kpis {
        margin-bottom: 60px
    }

    .panel-text.feature {
        width: 100%;
        max-width: none;
        flex-direction: column
    }

    .panel-text.feature.bubbles {
        order: 1
    }

    .top-navigation-wrapper {
        display: none
    }

    .panel-heading {
        min-width: auto;
        text-align: center;
        font-size: 30px;
        line-height: 35px
    }

    .panel-heading.informal {
        text-align: center;
        font-family: Mulish, sans-serif
    }

    .panel-heading.pricing {
        width: 100%
    }

    .panel-heading.heading-long.center {
        text-align: center
    }

    .panel-heading.center {
        text-align: center;
        font-size: 24px;
        line-height: 28px
    }

    .panel-heading.center.hero {
        font-size: 36px;
        line-height: 42px
    }

    .hero-image {
        width: 50%;
        height: auto;
        align-self: flex-start;
        top: 25%;
        bottom: 20px
    }

    .centeral-image {
        align-items: flex-start;
        display: none
    }

    .panel-paragraph {
        text-align: left;
        font-size: 16px;
        line-height: 25px
    }

    .panel-paragraph.git {
        text-align: center
    }

    .panel-paragraph.center {
        text-align: center;
        font-size: 16px;
        line-height: 25px
    }

    .panel-visual-dashboard {
        margin-top: 20px
    }

    .panel-visual-dashboard.side-by-side {
        max-width: 100%;
        order: 1
    }

    .panel-visual-dashboard.logos {
        flex-direction: row;
        justify-content: space-around
    }

    .panel-info-card {
        width: 100%;
        height: 300px
    }

    .info-card-title {
        font-size: 36px;
        line-height: 42px
    }

    .footer-link {
        max-width: none
    }

    .footer-links {
        grid-column-gap: 40px;
        grid-row-gap: 40px;
        flex-direction: column;
        grid-template-rows: auto auto;
        grid-template-columns: 1fr 1fr;
        grid-auto-columns: 1fr;
        display: grid
    }

    .footer-legal-social {
        grid-column-gap: 20px;
        grid-row-gap: 20px;
        flex-direction: column;
        align-items: center
    }

    .vp_visualframe {
        width: 100%;
        margin-left: 0
    }

    .vp_captionframe {
        width: 100%;
        align-items: center;
        margin-top: 40px;
        padding-bottom: 20px;
        padding-left: 10px;
        padding-right: 10px
    }

    .heading-2 {
        font-size: 18px;
        line-height: 22px
    }

    .heading-2.caption, .heading-2.ranking {
        text-align: center;
        margin-top: 10px;
        font-size: 18px;
        line-height: 22px
    }

    .vp1_t1 {
        text-align: left;
        align-self: center;
        font-size: 16px;
        line-height: 25px;
        position: relative
    }

    .content-panel-factoids.background-purple100.no-min-height {
        padding: 40px 20px
    }

    .content-panel-getintouch.background-gradient-dark {
        padding: 80px 24px
    }

    .content-panel-footer.no-min-height {
        padding: 40px 20px
    }

    .content-panel-hero.background-gradient-light.home {
        padding-top: 0;
        padding-left: 20px;
        padding-right: 20px
    }

    .content-panel-usp1, .content-panel-usp2, .content-panel-usp3 {
        min-height: auto;
        padding: 40px 20px
    }

    .panel-visual-modules {
        margin-top: 20px
    }

    .vp2_c-1 {
        width: 100%;
        padding-bottom: 20px;
        padding-left: 0;
        padding-right: 20px
    }

    .vp2-text {
        width: 95%;
        align-self: center;
        position: relative
    }

    .vp2_c-2, .vp2_c-3 {
        width: 100%;
        padding-bottom: 20px;
        padding-left: 0;
        padding-right: 20px
    }

    .vp3_t1 {
        align-self: center;
        position: relative
    }

    .button.solid-button {
        margin-top: 20px
    }

    .button.solid-button.btn-mbl {
        margin-left: 10px
    }

    .container-3 {
        width: 100%
    }

    .pop-up-form {
        width: 100%;
        padding-top: 40px;
        position: static
    }

    .work-details-container {
        flex-direction: row
    }

    .form {
        flex-direction: column
    }

    .form-text-contaner {
        width: 100%
    }

    .pop-up-wrapper {
        opacity: 0;
        display: none;
        overflow: scroll
    }

    .cancel-container {
        top: 20px
    }

    .form-container {
        width: 100%
    }

    .kpi-module {
        grid-column-gap: 12px;
        grid-row-gap: 12px;
        padding: 20px
    }

    .kpi-heading {
        margin-top: 0
    }

    .kpi-description {
        line-height: 20px
    }

    .expand, .expand.kpi-1, .expand.kpi-5, .expand.kpi-6, .expand.kpi-7, .expand.kpi-8, .expand.kpi-9 {
        top: 20px;
        right: 20px
    }

    .kpi-icon {
        width: 60px;
        height: 60px
    }

    .kpi-moduletitle {
        grid-column-gap: 0px;
        grid-row-gap: 0px
    }

    .kpi-modules {
        grid-column-gap: 12px;
        grid-row-gap: 12px;
        grid-template-columns: 1fr;
        padding: 12px
    }

    .panel-modules {
        width: 110%
    }

    .panel-modules.kpis {
        align-self: center
    }

    .kpi-overlays {
        overflow: visible
    }

    .kpi-overlay {
        grid-column-gap: 20px;
        grid-row-gap: 20px;
        padding: 10px 5px 20px 20px;
        display: none;
        top: 20px;
        bottom: 20px
    }

    .kpi-overlay.kpi-2, .kpi-overlay.kpi-3, .kpi-overlay.kpi-4, .kpi-overlay.kpi-5, .kpi-overlay.kpi-6, .kpi-overlay.kpi-7, .kpi-overlay.kpi-8 {
        grid-column-gap: 24px;
        grid-row-gap: 24px;
        display: none;
        top: 60px
    }

    .kpi-overlay.kpi-1 {
        z-index: auto;
        object-fit: fill;
        display: none;
        top: 60px;
        overflow: scroll
    }

    .kpi-overlay.kpi-9 {
        grid-column-gap: 24px;
        grid-row-gap: 24px;
        display: none;
        top: 60px
    }

    .kpi-icon-large {
        margin-bottom: 20px
    }

    .kpi-overlay-title {
        width: 100%
    }

    .kpi-heading-h2 {
        margin-top: 0;
        font-size: 24px;
        line-height: 28px
    }

    .kpi-subhead-h3 {
        font-size: 20px;
        line-height: 23px
    }

    .kpi-overlay-details {
        grid-column-gap: 18px;
        grid-row-gap: 18px
    }

    .close {
        align-items: center;
        top: 20px;
        right: 20px
    }

    .text-block-14, .kpi-bodytext {
        font-size: 16px;
        line-height: 25px
    }

    .kpi-overlay-contentscroll {
        grid-column-gap: 30px;
        grid-row-gap: 30px;
        object-fit: fill;
        padding-right: 20px;
        display: flex;
        overflow: scroll
    }

    .panel-subheading.informal {
        font-family: Mulish, sans-serif;
        font-size: 24px;
        line-height: 28px
    }

    .panel-subheading.informal.center {
        font-family: Mulish, sans-serif
    }

    .panel-visual {
        width: 100%;
        grid-column-gap: 16px;
        grid-row-gap: 16px;
        flex-direction: column;
        grid-template-rows: auto auto;
        grid-template-columns: 1fr 1fr;
        grid-auto-columns: 1fr;
        align-self: flex-end;
        align-items: center;
        display: flex
    }

    .panel-visual.feature {
        order: 2;
        align-self: center;
        align-items: center
    }

    .panel-visual.feature.exta {
        align-self: center;
        margin-left: 0
    }

    .content-panel-story.first.background_purple-100, .content-panel-story.first.grandient.informal {
        padding-top: 120px;
        padding-left: 20px;
        padding-right: 20px
    }

    .content-panel-story.varheight, .content-panel-story.varheight-2 {
        padding-left: 20px;
        padding-right: 20px
    }

    .bullet {
        text-align: left;
        font-size: 16px;
        line-height: 25px
    }

    .bullet.git {
        text-align: center
    }

    .div-block-13 {
        margin-top: 10vh
    }

    .panel-quote.informal.cloud {
        align-self: center;
        font-size: 30px;
        line-height: 35px
    }

    .dropdown-list-2 {
        background-color: #fff
    }

    .mobile-navbar {
        position: fixed
    }

    .panel-subheading-step.informal {
        font-size: 24px;
        line-height: 28px
    }

    .panel-focusarea.purple {
        text-align: center;
        align-self: center
    }

    .pricing-package {
        padding-top: 20px
    }

    .package-price {
        font-size: 30px
    }

    .package-top {
        border-bottom-width: 0
    }

    .checkmark {
        text-align: left;
        font-size: 16px;
        line-height: 25px
    }

    .checkmark.git {
        text-align: center
    }

    .pricing-bullet-text {
        text-align: left;
        font-size: 16px;
        line-height: 25px
    }

    .pricing-bullet-text.git {
        text-align: center
    }

    .faq {
        grid-column-gap: 10px;
        grid-row-gap: 10px;
        padding-right: 5px
    }

    .question {
        font-size: 16px;
        line-height: 22px
    }

    .left-arrow.center {
        top: 20%;
        left: -40px
    }

    .right-arrow.center {
        top: 20%;
        right: -35px
    }

    .paragraph, .answer {
        font-size: 16px;
        line-height: 25px
    }

    .dropdown-list {
        background-color: transparent
    }

    .scroll-image {
        width: 90%;
        margin-bottom: 20px
    }

    .div-block-29 {
        width: 80%
    }

    .image-26, .image-27, .image-28 {
        height: 20px
    }

    .panel-visual-modules-full {
        margin-top: 20px
    }

    .slidetext.ranking {
        width: 100%;
        text-align: center;
        margin-left: 0;
        line-height: 25px
    }

    .vp2-screentitle {
        padding-right: 0
    }

    .cirlcenumber {
        display: none
    }

    .paragraph-2 {
        text-align: center
    }

    .top-a {
        min-height: 200px
    }

    .logos {
        grid-column-gap: 20px;
        grid-row-gap: 20px;
        flex-wrap: wrap;
        justify-content: center;
        display: flex
    }

    .page-padding.s0 {
        margin-bottom: 0;
        padding-top: 1em;
        padding-bottom: 1em
    }

    .padding-vertical {
        padding-left: 0;
        padding-right: 0
    }

    .padding-vertical.padding-xxlarge {
        padding-top: 2rem;
        padding-bottom: 2rem
    }

    .logo_component-slider {
        grid-column-gap: 2rem;
        grid-row-gap: 2rem;
        overflow: hidden
    }

    .logo-slider-img {
        width: 100px
    }

    .logo_component-slider-2 {
        grid-column-gap: 2rem;
        grid-row-gap: 2rem;
        overflow: hidden
    }

    .section-cards {
        margin-left: 20px;
        margin-right: 20px
    }

    .heading-purple, .heading-purple.blue, .heading-purple.fuschia {
        font-size: 30px
    }

    .listi-item-about-us {
        width: auto
    }

    .step-block {
        margin-bottom: 140px
    }

    .img-block {
        width: 90%
    }

    .label {
        text-align: center
    }

    .timeline-section {
        margin-top: 220px
    }

    .steps-clone {
        display: block;
        position: static
    }

    .heading-21 {
        text-align: center
    }

    .content-2 {
        font-size: 20px
    }

    .text-6em {
        font-size: 3.7em
    }

    .dot-2._8 {
        background-color: var(--purple-600-light);
        top: 99%
    }

    .text-link {
        margin-top: 29px;
        margin-left: 20px
    }

    .timeline-month {
        font-size: 1.7em
    }

    .gif-image {
        height: 80%
    }

    .gif-image.right {
        height: auto;
        flex: 0 auto;
        align-self: auto
    }

    .gif-image.left {
        height: auto
    }

    .timeline-text {
        padding-bottom: 20px;
        font-size: 12px
    }

    .container-11 {
        padding-left: 20px;
        padding-right: 20px
    }

    .container-11.flex-verticle {
        justify-content: flex-end;
        padding-left: 10px;
        padding-right: 10px
    }

    .timeline-item {
        height: 220px
    }

    .timeline-item.left-item {
        height: auto;
        position: relative;
        top: 280px
    }

    .timeline-item.right {
        height: auto
    }

    .timeline-content-wrapper {
        grid-row-gap: 195vh
    }

    .timeline-track {
        width: 7px
    }

    .new-section {
        padding-top: 100px;
        padding-bottom: 100px
    }

    .timeline-wrapper {
        width: 93%;
        display: none
    }

    .container-12 {
        margin-top: 60px;
        padding-bottom: 40px
    }

    .div-block-36 {
        margin-top: 40px
    }

    .div-block-37 {
        text-align: center;
        display: block
    }

    .heading-23 {
        text-align: center;
        line-height: 43px
    }

    .quick-stack {
        grid-column-gap: 20px
    }

    .careers-hero {
        margin-top: 0
    }

    .paragraph-18 {
        font-size: 16px
    }

    .quick-stack-2, .quick-stack-3 {
        padding-left: 20px;
        padding-right: 20px
    }

    .paragraph-19 {
        margin-left: 10px;
        margin-right: 10px
    }

    .container-14 {
        max-width: none
    }

    .gallery-wrapper {
        grid-template-columns: 1fr
    }

    .gallery-slide-wrapper {
        max-width: 100%;
        margin-right: 0%
    }

    .gallery-slider-left {
        left: -20px
    }

    .gallery-slider-right {
        right: -20px
    }

    .image {
        max-height: 65vw
    }

    .carousel-text-container {
        margin-left: 10px;
        margin-right: 10px
    }

    .quick-stack-4 {
        padding-left: 20px
    }

    .lottie-loading-animation {
        width: 80%
    }

    .job-location {
        padding-right: 0
    }

    .section-dark-bg.my-90.py-60 {
        margin-top: 0
    }

    .gallery-slide-2, .slider-5 {
        overflow: hidden
    }

    .image-slider {
        max-height: 100px
    }

    .heading-54 {
        margin-left: 10px;
        margin-right: 10px
    }

    .quick-stack-5 {
        padding-top: 20px
    }

    .container-19 {
        max-width: none
    }

    .centered-heading {
        margin-bottom: 24px
    }

    .team-grid {
        grid-template-columns: 1fr
    }

    .nav-menu-two {
        flex-direction: column
    }
}

#w-node-_4c638279-08c9-8935-3aa2-067822e77c12-22e77c10 {
    grid-area: 1/1/2/2
}

#w-node-_4c638279-08c9-8935-3aa2-067822e77c16-22e77c10 {
    grid-area: span 1/span 3/span 1/span 3
}

#w-node-f04f0a0a-99fe-b09d-7d74-1e56450edea2-ec4cd88e, #w-node-a6722af6-ccad-84cf-cb0d-e438ccd35a40-ec4cd88e, #w-node-c934fc98-d157-206f-3ef4-2634f6e02c79-ec4cd88e, #w-node-_78a36195-77e1-2400-0919-02a1062a925b-ec4cd88e {
    grid-area: span 1/span 1/span 1/span 1
}

#w-node-c757d78e-5c52-2c67-dd88-694cc8b3d430-34b12955 {
    grid-area: span 9/span 1/span 9/span 1
}

#w-node-_58fe5cff-55cd-f671-b9ce-a1f351a3e52c-c811a242 {
    grid-template-rows: auto;
    grid-template-columns: 1fr 1fr
}

#w-node-_84c438da-8c36-6be0-f821-012abf352b7c-c811a242, #w-node-_97e9fdaf-4864-f714-0a68-029a8c441029-c811a242 {
    grid-area: span 1/span 1/span 1/span 1
}

#w-node-_65215efe-375f-05f9-f30f-b62ba500abc0-c811a242 {
    grid-template-rows: auto auto;
    grid-template-columns: 1fr 1fr 1fr
}

#w-node-a017f22f-e401-2172-03bf-da0bc4ab3277-c811a242, #w-node-_0060fd2f-4c5c-05c7-3c65-d8b54d71321a-c811a242, #w-node-_666a89e0-bf16-b67b-10eb-e839dac91eac-c811a242, #w-node-c5c86bd8-b192-b099-d076-7fac0c31bc01-c811a242, #w-node-_20578d9d-e661-3f3f-a03e-e34fa9e37d4b-c811a242, #w-node-_59940261-ed40-bb7d-bc35-8b965ea273d0-c811a242 {
    grid-area: span 1/span 1/span 1/span 1
}

#w-node-_5b718d38-df72-37cb-abf5-1981f8a05996-c811a242 {
    grid-template-rows: auto auto auto;
    grid-template-columns: 1fr 1fr 1fr
}

#w-node-_5b718d38-df72-37cb-abf5-1981f8a05997-c811a242, #w-node-_5b718d38-df72-37cb-abf5-1981f8a0599c-c811a242, #w-node-_5b718d38-df72-37cb-abf5-1981f8a059a1-c811a242, #w-node-_5b718d38-df72-37cb-abf5-1981f8a059a6-c811a242, #w-node-_5b718d38-df72-37cb-abf5-1981f8a059ab-c811a242, #w-node-_5b718d38-df72-37cb-abf5-1981f8a059b0-c811a242, #w-node-_44ce52fc-6332-f2b1-6f19-bee80e0dcd7b-c811a242, #w-node-_4a9b59bf-5cad-221b-895c-ffcba92e76f0-c811a242, #w-node-_96bd8d48-5294-20b9-f478-b0f4371ba121-c811a242 {
    grid-area: span 1/span 1/span 1/span 1
}

#w-node-c20616df-b61a-da71-f56c-2082d600869d-c811a242 {
    grid-template-rows: auto;
    grid-template-columns: 1fr 3.25fr
}

#w-node-_0da7f54e-5679-b050-9382-95e86c8596cd-afccd5b4 {
    grid-template-rows: auto;
    grid-template-columns: 1fr 1.75fr
}

#w-node-c1aec756-8e8c-ba0d-d750-71558101c8a0-afccd5b4 {
    grid-template-rows: auto;
    grid-template-columns: 1fr 1fr 1fr
}

#w-node-ba1bf76b-df6c-84c5-9755-16e3f94e24e2-afccd5b4 {
    grid-template-rows: auto auto auto auto;
    grid-template-columns: 1fr 1fr
}

#w-node-_94c77e14-ed7a-3615-72a5-e717a701fde1-afccd5b4, #w-node-_52b1dfb1-a578-b3bd-ea4a-233de8b15d0a-afccd5b4 {
    grid-template-rows: auto;
    grid-template-columns: 1fr 1fr
}

#w-node-_6c687b8b-051d-1881-7736-b64c672b52c3-944f5ff1, #w-node-_6c687b8b-051d-1881-7736-b64c672b52ce-944f5ff1, #w-node-_6c687b8b-051d-1881-7736-b64c672b52d8-944f5ff1 {
    grid-area: span 1/span 1/span 1/span 1
}

@media screen and (min-width:1440px) {
    #w-node-_4c638279-08c9-8935-3aa2-067822e77c12-22e77c10 {
        grid-area: 1/1/2/3
    }

    #w-node-_4c638279-08c9-8935-3aa2-067822e77c16-22e77c10 {
        grid-area: span 1/span 3/span 1/span 3
    }

    #w-node-c757d78e-5c52-2c67-dd88-694cc8b3d43d-34b12955 {
        align-self: auto
    }

    #w-node-_6c687b8b-051d-1881-7736-b64c672b52ce-944f5ff1, #w-node-_6c687b8b-051d-1881-7736-b64c672b52d8-944f5ff1 {
        grid-area: span 1/span 1/span 1/span 1
    }
}

@media screen and (max-width:991px) {
    #w-node-_4c638279-08c9-8935-3aa2-067822e77c12-22e77c10 {
        grid-area: 1/1/2/4
    }
}

@media screen and (max-width:767px) {
    #w-node-c1aec756-8e8c-ba0d-d750-71558101c8a0-afccd5b4, #w-node-_94c77e14-ed7a-3615-72a5-e717a701fde1-afccd5b4, #w-node-_52b1dfb1-a578-b3bd-ea4a-233de8b15d0a-afccd5b4 {
        grid-template-rows: auto;
        grid-template-columns: 1fr
    }
}

@media screen and (max-width:479px) {
    #w-node-_4c638279-08c9-8935-3aa2-067822e77c16-22e77c10 {
        grid-area: span 1/span 3/span 1/span 3
    }

    #w-node-_58fe5cff-55cd-f671-b9ce-a1f351a3e52c-c811a242 {
        grid-template-rows: auto;
        grid-template-columns: 1fr
    }

    #w-node-_65215efe-375f-05f9-f30f-b62ba500abc0-c811a242 {
        grid-template-rows: auto auto;
        grid-template-columns: 1fr
    }

    #w-node-_5b718d38-df72-37cb-abf5-1981f8a05996-c811a242 {
        grid-template-rows: auto auto auto;
        grid-template-columns: 1fr
    }

    #w-node-c20616df-b61a-da71-f56c-2082d600869d-c811a242, #w-node-_0da7f54e-5679-b050-9382-95e86c8596cd-afccd5b4 {
        grid-template-rows: auto;
        grid-template-columns: 1fr
    }

    #w-node-c1aec756-8e8c-ba0d-d750-71558101c8a0-afccd5b4 {
        grid-template-rows: auto auto auto;
        grid-template-columns: 1fr
    }

    #w-node-ba1bf76b-df6c-84c5-9755-16e3f94e24e2-afccd5b4, #w-node-_94c77e14-ed7a-3615-72a5-e717a701fde1-afccd5b4, #w-node-_52b1dfb1-a578-b3bd-ea4a-233de8b15d0a-afccd5b4 {
        grid-template-rows: auto;
        grid-template-columns: 1fr
    }
}
  </style>
  <style>
    .w-slider-dot {
      background: white;
    }

    .w-slider-dot {
      border: 1px solid #7978de;
    }

    .w-slider-dot.w-active {
      background: #7978de;
    }
  </style>

  <script async src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
</head>

<body class="body">
  <div class="w-embed w-iframe">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WW98W9N" height="0" width="0"
        style="display: none; visibility: hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
  </div>
  <div class="top-navigation-wrapper">
    <div class="navbar-content">
      <a href="/" aria-current="page" class="home-link-block w-inline-block w--current"><img
          src="https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/647d9d0bc78e346059974009_Logo%402x.webp"
          loading="lazy" alt="" class="image-2" /></a>
      <div class="menu-sections">
        <div data-hover="true" data-delay="0" class="dropdown-3 w-dropdown">
           
          <div class="dropdown-toggle-2 w-dropdown-toggle">
            <div class="section-text"><a style='text-decoration: none; color: inherit; cursor: pointer;' href="{{ route('explore') }}">Explore</a></div>
          </div>
        </div>
        <a href="/pricing" class="link-block w-inline-block">
          <div class="section-item-wrapper">
            <div class="section-text"><a style='text-decoration: none; color: inherit; cursor: pointer;' href="{{ route('page', 'how-it-works') }}">How its works</a></div>
          </div>
        </a><a href="https://resources.latana.com/articles/" class="link-block w-inline-block">
          <div class="section-item-wrapper">
            <div class="section-text"><a style='text-decoration: none; color: inherit; cursor: pointer;' href="https://github.com/naveed-siddiqi/lumos-dao" target='_blank'>Github</a></div>
          </div>
        </a>
      </div>
      <div class="menu-cta">
        <a data-w-id="f4a9faa4-903f-458c-a94b-cfd4c516ce63" href="#" class="button w-button" data-bs-toggle="modal" data-bs-target="#ConnectWallet">Connect Wallet</a>
      </div>
    </div>
  </div>
  <div data-animation="default" data-collapse="all" data-duration="400" data-easing="ease" data-easing2="ease"
    data-doc-height="1" role="banner" class="mobile-navbar w-nav">
    <div class="container-6 w-container">
      <a href="/" aria-current="page" class="w-nav-brand w--current"><img alt="" loading="lazy"
          src="https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/647d9d0bc78e346059974009_Logo%402x.webp"
          class="logo-mb" /></a>
      <nav role="navigation" class="nav-menu w-nav-menu">
        <div data-delay="0" data-hover="false" class="dropdown w-dropdown">
          <div class="w-dropdown-toggle">
            <div class="w-icon-dropdown-toggle"></div>
            <div class="text-block-20">Product</div>
          </div>
          <nav class="dropdown-list-2 w-dropdown-list">
            <a href="/why-measure-brand-performance" class="w-dropdown-link">Why measure brand performance?</a><a
              href="/which-brand-metrics-matter" class="w-dropdown-link">Which metrics should I be tracking</a><a
              href="/how-does-latana-generate-insights" class="w-dropdown-link">How does Latana generate brand
              insights?</a><a href="/use-cases" class="w-dropdown-link">Use Cases</a>
          </nav>
        </div>
        <div data-delay="0" data-hover="false" class="dropdown-2 w-dropdown">
          <div class="w-dropdown-toggle">
            <div class="w-icon-dropdown-toggle"></div>
            <div class="text-block-21">Why Latana</div>
          </div>
          <nav class="dropdown-list-2 w-dropdown-list">
            <a href="/why-latana/better-data" class="w-dropdown-link">Better data</a><a href="/why-latana/easy-to-use"
              class="w-dropdown-link">Easy to use</a>
          </nav>
        </div>
        <a href="/pricing" class="nav-link w-nav-link">Pricing</a><a href="https://resources.latana.com/articles/"
          class="nav-link-2 w-nav-link">Resources</a><a href="https://app.latana.com/login"
          class="nav-link-3 w-nav-link">Login</a><a data-w-id="fcf45e15-f05c-8707-2e61-6acbcd10cce0" href="#"
          class="button w-button">Book a demo</a>
      </nav>
      <div class="menu-button w-nav-button">
        <div class="icon w-icon-nav-menu"></div>
      </div>
    </div>
  </div>
  <main id="Hero" class="content-panel-hero background-gradient-light home">
    <div class="content flush-left hero">
      <div class="panel-text side-by-side">
        <h2 class="panel-heading center hero">
          Empower Your Governance with LumosDAO
        </h2>
        <p class="panel-paragraph">
          LumosDAO revolutionizes decentralized governance on Soroban, enabling transparent voting and proposal creation
          for communities to grow and collaborate seamlessly. </p>
        <a data-w-id="a7cac35f-1429-777b-af96-131c94642000" href="#" class="button w-button">Learn more</a>
      </div>
      <div class="panel-visual-dashboard side-by-side">
        <div class="centeral-image">
          <div class="html-embed w-embed w-iframe">
            <video width="600" height="450" controls>
              <source src="{{ asset('images/raza_rizvi91-v2.mp4') }}"  type="video/mp4">
              Your browser does not support the video tag.
            </video>
          </div>
        </div>
      </div>
    </div>

  </main>

  <main class="wrapper">
    <h2 class="trust-by-heading heading-2 ranking">
      Trusted by:
    </h2>
    <section class="w-layout-blockcontainer ticker w-container">
      <div class="tooltip">
        <div class="ticker-content">
          <div class="logo">
            <img
              src="https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64d0e0593f452fef669d3d53_patagonia_logo.svg"
              loading="lazy" alt="" />
          </div>
        </div>
      </div>
      <div class="tooltip">
        <div class="ticker-content">
          <div class="logo">
            <img
              src="https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64d0e059c41267a28dd51b38_babbel_logo.svg"
              loading="lazy" alt="" />
          </div>
        </div>
      </div>
      <div class="tooltip">
        <div class="ticker-content">
          <div class="logo">
            <img
              src="https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64d0e0590ac9e1c56edba816_thrifty_logo.svg"
              loading="lazy" alt="" />
          </div>
        </div>
      </div>
      <div class="tooltip hide">
        <div class="ticker-content">
          <div class="logo">
            <img
              src="https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64d0e9fe7c26d4d92287d1a6_silentnight_logo.svg"
              loading="lazy" alt="" />
          </div>
        </div>
      </div>
      <div class="tooltip">
        <div class="ticker-content">
          <div class="logo">
            <img
              src="https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64d0eb3e5f4d0385b7415657_logo%2Bhungryroot.svg"
              loading="lazy" alt="" class="image-hungryroot" />
          </div>
        </div>
      </div>
      <div class="tooltip">
        <div class="ticker-content">
          <div class="logo sephora">
            <img
              src="https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64d0e059449eb28e9c85f46a_Sephora_logo_purple.svg"
              loading="lazy" alt="" />
          </div>
        </div>
      </div>
      <div class="tooltip">
        <div class="ticker-content">
          <div class="logo">
            <img
              src="https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64b11a2fd8bd3f766034f447_BitcoinDE_dark.svg"
              loading="lazy" alt="" />
          </div>
        </div>
      </div>
      <div class="tooltip">
        <div class="ticker-content">
          <div class="logo">
            <img
              src="https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64b11a2e616e0f54d835463a_Birkenstock_dark.svg"
              loading="lazy" alt="" class="image-39" />
          </div>
        </div>
      </div>
      <div class="tooltip">
        <div class="ticker-content">
          <div class="logo">
            <img
              src="https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64b11a2d151326ef4e23bed3_LeapFrog_dark.svg"
              loading="lazy" alt="" />
          </div>
        </div>
      </div>
      <div class="tooltip">
        <div class="ticker-content">
          <div class="logo">
            <img
              src="https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64b11a2fbfa43fcb05188b2f_Hertz_dark.svg"
              loading="lazy" alt="" />
          </div>
        </div>
      </div>
      <div class="tooltip">
        <div class="ticker-content">
          <div class="logo">
            <img
              src="https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64b11a2fbfa43fcb05188b2f_Hertz_dark.svg"
              loading="lazy" alt="" />
          </div>
        </div>
      </div>
      <div class="tooltip">
        <div class="ticker-content">
          <div class="logo">
            <img
              src="https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64b11a2fbfa43fcb05188b2f_Hertz_dark.svg"
              loading="lazy" alt="" />
          </div>
        </div>
      </div>
      <div class="tooltip">
        <div class="ticker-content">
          <div class="logo">
            <img
              src="https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64b11a2fbfa43fcb05188b2f_Hertz_dark.svg"
              loading="lazy" alt="" />
          </div>
        </div>
      </div>
      <div class="tooltip">
        <div class="ticker-content">
          <div class="logo">
            <img
              src="https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64b11a2fbfa43fcb05188b2f_Hertz_dark.svg"
              loading="lazy" alt="" />
          </div>
        </div>
      </div>
    </section>
  </main>
  <section id="strategy-section" class="content-panel-usp1">
    <div class="content home vp w-container">
      <div class="panel-text centered vp">
        <h2 class="panel-heading center">
          Core Features of LumosDAO
        </h2>
        <p class="panel-paragraph center">
          Unlock the full potential of decentralized governance with LumosDAO's suite of features designed for
          efficiency, transparency, and community empowerment. Explore our core functionalities that set the foundation
          for democratic decision-making.
        </p>
      </div>
      <div class="panel-visual-dashboard">
        <div class="vp_visualframe">
          <div data-delay="4000" data-animation="fade" class="vp1-slider w-slider" data-autoplay="true"
            data-easing="ease" data-hide-arrows="false" data-disable-swipe="false" data-autoplay-limit="0"
            data-nav-spacing="3" data-duration="250" data-infinite="true">
            <div class="mask-2 w-slider-mask">
              <div data-w-id="bcebe238-6b4b-6589-c1d1-cdac115c2e31" class="slide-1 w-slide">
                <img width="894"
                  sizes="(max-width: 479px) 92vw, (max-width: 767px) 72vw, (max-width: 991px) 71vw, (max-width: 1439px) 67vw, 894px"
                  src="https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64ae78ba457bb4910722f052_HP-VP1-S1.webp"
                  loading="lazy" alt="" srcset="
                      https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64ae78ba457bb4910722f052_HP-VP1-S1-p-500.webp   500w,
                      https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64ae78ba457bb4910722f052_HP-VP1-S1-p-800.webp   800w,
                      https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64ae78ba457bb4910722f052_HP-VP1-S1-p-1080.webp 1080w,
                      https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64ae78ba457bb4910722f052_HP-VP1-S1-p-1600.webp 1600w,
                      https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64ae78ba457bb4910722f052_HP-VP1-S1.webp        1788w
                    " class="screen" />
              </div>
              <div data-w-id="bcebe238-6b4b-6589-c1d1-cdac115c2e33" class="slide-2 w-slide">
                <img width="894"
                  sizes="(max-width: 479px) 92vw, (max-width: 767px) 72vw, (max-width: 991px) 71vw, (max-width: 1439px) 67vw, 894px"
                  src="https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64ae60c7c93bc48ef730547a_HP-VP1-S2.webp"
                  loading="lazy" alt="" srcset="
                      https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64ae60c7c93bc48ef730547a_HP-VP1-S2-p-500.webp   500w,
                      https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64ae60c7c93bc48ef730547a_HP-VP1-S2-p-800.webp   800w,
                      https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64ae60c7c93bc48ef730547a_HP-VP1-S2-p-1080.webp 1080w,
                      https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64ae60c7c93bc48ef730547a_HP-VP1-S2-p-1600.webp 1600w,
                      https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64ae60c7c93bc48ef730547a_HP-VP1-S2.webp        1788w
                    " class="screen" />
              </div>
              <div data-w-id="bcebe238-6b4b-6589-c1d1-cdac115c2e35" class="slide-3 w-slide">
                <img width="894"
                  sizes="(max-width: 479px) 92vw, (max-width: 767px) 72vw, (max-width: 991px) 71vw, (max-width: 1439px) 67vw, 894px"
                  src="https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64ae60c72b165bfbdd22b9c1_HP-VP1-S3.webp"
                  loading="lazy" alt="" srcset="
                      https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64ae60c72b165bfbdd22b9c1_HP-VP1-S3-p-500.webp   500w,
                      https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64ae60c72b165bfbdd22b9c1_HP-VP1-S3-p-800.webp   800w,
                      https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64ae60c72b165bfbdd22b9c1_HP-VP1-S3-p-1080.webp 1080w,
                      https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64ae60c72b165bfbdd22b9c1_HP-VP1-S3-p-1600.webp 1600w,
                      https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64ae60c72b165bfbdd22b9c1_HP-VP1-S3.webp        1788w
                    " class="screen" />
              </div>
              <div data-w-id="bcebe238-6b4b-6589-c1d1-cdac115c2e31" class="slide-4 w-slide">
                <img width="894"
                  sizes="(max-width: 479px) 92vw, (max-width: 767px) 72vw, (max-width: 991px) 71vw, (max-width: 1439px) 67vw, 894px"
                  src="https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64ae60c72b165bfbdd22b9c1_HP-VP1-S3.webp"
                  loading="lazy" alt="" srcset="
                      https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64ae60c72b165bfbdd22b9c1_HP-VP1-S3-p-500.webp   500w,
                      https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64ae60c72b165bfbdd22b9c1_HP-VP1-S3-p-800.webp   800w,
                      https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64ae60c72b165bfbdd22b9c1_HP-VP1-S3-p-1080.webp 1080w,
                      https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64ae60c72b165bfbdd22b9c1_HP-VP1-S3-p-1600.webp 1600w,
                      https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64ae60c72b165bfbdd22b9c1_HP-VP1-S3.webp        1788w
                    " class="screen" />
              </div>
            </div>
            <div class="left-arrow w-slider-arrow-left">
              <img alt="" loading="lazy"
                src="https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64ae727eae5441596265f9de_Backwards.svg" />
            </div>
            <div class="right-arrow w-slider-arrow-right">
              <img alt="" loading="lazy"
                src="https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/64ae727e0f19a375e4ffe0dc_Forward.svg" />
            </div>

            <div class="slide-nav-2 w-slider-nav w-round"></div>
          </div>
        </div>
        <div class="w-layout-vflex vp_captionframe">
          <div class="w-layout-vflex">
            <div class="vp1_t1">
              <h3 class="heading-2 caption">Seamless DAO Creation</h3>
              <p class="paragraph-2">
                Instantly establish your DAO with customizable governance structures to suit your community’s unique
                needs."
              </p>
            </div>
            <div class="vp1_t2">
              <h3 class="heading-2">Transparent Proposal & Voting</h3>
              <p>
                Facilitate democratic decisions with our transparent proposal submission and voting mechanism, ensuring
                every voice is heard.
              </p>
            </div>
            <div class="vp1_t3">
              <h3 class="heading-2">Flexible Voting Power Delegation</h3>
              <p>
                Empower members to delegate their voting rights, enhancing participation and inclusivity within your
                DAO.
              </p>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="strategy-section" class="content-panel-usp1">
    <div class="content home vp w-container">
      <div class="panel-text centered vp">
        <h2 class="panel-heading center">Why Choose LumosDAO</h2>
        <p>
          LumosDAO offers a range of benefits tailored to meet the needs of both DAO members and creators, ensuring a
          robust, transparent, and user-friendly platform for decentralized governance.
        </p>
      </div>
      <div class="why-choose">
        <ul>
          <h3 class="heading-2 ranking" aria-hidden="true">
            For DAO Creators:
          </h3>
          <li>
            <strong> Easy Setup:</strong><br />
            Simplified DAO creation tools enable quick launch of decentralized organizations with customizable
            governance models.
          </li>
          <li>
            <strong>Financial Oversight:</strong><br />
            Integrated budget/treasury management features provide clear oversight of financial operations and fund
            allocation.

          </li>
          <li>
            <strong>Scalable Governance:</strong><br />
            The platform supports scalable governance structures, accommodating growing communities and evolving
            governance needs.

          </li>

          <li>
            <strong> Operational Efficiency:</strong><br />
            Automated processes for proposals, voting, and member management reduce administrative overhead.
          </li>

          <li>
            <strong>Community Building: </strong><br />
            Tools for engagement and communication help in nurturing an active and involved DAO community.
          </li>
          <li>
            <strong>Token Issuance: </strong><br />
            Generate new tokens directly on LumosDAO and seamlessly set up their corresponding DAO.
          </li>
        </ul>
        <ul>
          <h3 class="heading-2 ranking" aria-hidden="true">
            For DAO Members:
          </h3>
          <li>
            <strong>Enhanced Participation: </strong><br />
            With voting power delegation, members can contribute to decision-making processes, even with limited time or
            expertise.
          </li>
          <li>
            <strong>Community Engagement: </strong><br />
            Direct involvement in governance fosters a stronger sense of community and shared purpose.
          </li>
          <li>
            <strong>Greater Transparency:</strong><br />
            Direct involvement in governance fosters a stronger sense of community and shared purpose.
          </li>
          <li>
            <strong>Security and Trust:</strong><br />
            Advanced security protocols protect members' interests and ensure the integrity of voting and transactions.
          </li>

          <li>
            <strong> Accessibility:</strong><br />
            A user-friendly interface makes participation in DAO activities straightforward for members of all technical
            levels.
          </li>
        </ul>
      </div>
    </div>
  </section>

  <section class="content-panel-getintouch background-gradient-dark">
    <div class="">
      <div class="panel-text git">
        <h2 class="panel-heading">Get in touch</h2>
        <p class="panel-paragraph git">
          We're here to help and answer any questions you might have about LumosDAO. Whether you're curious about
          decentralized governance, need assistance with the platform, or want to join our growing community, our team
          is ready to connect with you.
        </p>
        <p class="panel-paragraph git">
          <strong>Email Us:</strong>
          For detailed inquiries or support, drop us an email at info@lumosdao.io we'll get back to you as soon as
          possible.
        </p>
        <p class="panel-paragraph git">
          <strong>Reach Out on X.com:</strong>
          For quick questions or to follow our updates, message us directly at <strong>@DAOLumos</strong>. Let's start a
          conversation!
        </p>
        <p class="panel-paragraph git">
          We look forward to hearing from you and welcoming you to the LumosDAO community.
        </p>
        <a data-w-id="b36860b6-9555-4ebd-8211-5580cf70d175" href="#" class="button solid-button cta w-button">Book a
          demo</a>
      </div>
    </div>
  </section>

  <script src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js?site=6475c5eea8e20ed4cd6ee36e"
    type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
    crossorigin="anonymous"></script>
  <script src="https://assets-global.website-files.com/6475c5eea8e20ed4cd6ee36e/js/webflow.f6f4c168b.js"
    type="text/javascript"></script>
  <script>
    // get elements
    let menuLink = $(".menu-sections > a");
    let content = $(".menu_dropdown_content");
    let activeDropdown = $(".menu_dropdown_content.active");
    let menuArrow = $(".menu_arrow_wrap");
    let topNavBar = $(".top-navigation-wrapper");
    let latanaLogo = $(".home-link-block");
    let showDropdown;
    let menuCTA = $(".menu-cta > a");
    let dropdownTimer;
    //remove old header navbar
    E('main_header_div').style.display = 'none'
    function setDropdownAnimation(dropdownWrap) {
      showDropdown = gsap.timeline({
        onReverseComplete: () => {
          dropdownWrap.css("display", "none");
          menuLink.removeClass("active");
          topNavBar.css("backgroundColor", "rgba(255, 255, 255, 0.01)");
        },
        paused: true,
      });

      showDropdown.fromTo(
        dropdownWrap,
        {
          opacity: 0.7,
          y: -50,
        },
        {
          opacity: 1,
          y: 0,
          duration: 0.3,
        }
      );
    }

    function revealDropdown(currentLink, currentContent) {
      let dropdownWrap = currentContent.find("div").first();
      let arrowDrop = currentLink.find("img");
      dropdownWrap.css("display", "flex");
      setDropdownAnimation(dropdownWrap);
      showDropdown
        .restart()
        .to(
          topNavBar,
          {
            backgroundColor: "white",
          },
          "<"
        )
        .to(
          arrowDrop,
          {
            rotate: 180,
            y: 5,
          },
          "<"
        );
    }

    function resetAnimation() {
      showDropdown.reverse();
      $(".menu_dropdown_content.active").removeClass("active");
    }

    function closeDropdown() {
      dropdownTimer = setTimeout(resetAnimation, 10);
    }

    function cancelCloseDropdown() {
      clearTimeout(dropdownTimer);
    }

    latanaLogo.on("mouseenter", function () {
      if (showDropdown) {
        resetAnimation();
      }
    });

    menuCTA.on("mouseenter", function () {
      if (showDropdown) {
        resetAnimation();
      }
    });

    menuLink.on("mouseenter", function () {
      let activeDropdown = $(".menu_dropdown_content.active")
        .children()
        .attr("class");
      let activeMenu = $(this).attr("data-menu-link");
      if (activeDropdown !== activeMenu && showDropdown) {
        resetAnimation();
      }

      const hasInnerMenus = $("." + activeMenu).length > 0;
      let previousLink = menuLink.filter(".active").removeClass("active");
      let currentLink = $(this).addClass("active");
      let previousContent = content.filter(".active").removeClass("active");
      let currentContent = content.eq($(this).index() - 1).addClass("active");
      if (hasInnerMenus) {
        revealDropdown(currentLink, currentContent);
      }
    });

    menuLink.on("mouseleave", function () {
      let activeDropdown = $(".menu_dropdown_content.active")
        .children()
        .attr("class");
      let activeMenu = $(this).attr("data-menu-link");
      if (activeDropdown !== activeMenu && showDropdown) {
        closeDropdown();
      }
    });

    content.on("mouseenter", function () {
      cancelCloseDropdown();
    });

    content.on("mouseleave", function () {
      closeDropdown();
    });
  </script>

  <style>
    @keyframes ticker {
      from {
        transform: translate3d(0, 0, 0);
      }

      to {
        transform: translate3d(-1250%, 0, 0);
      }
    }

    .tooltip {
      padding: 0 1em;
      position: relative;
      /* Add position: relative */
      display: inline-block;
      animation: linear 55s infinite ticker;
    }

    .tooltip .tooltiptext {
      visibility: hidden;
      position: absolute;
      z-index: 1;
      border-radius: 6px;
      /*top: 250px;*/
      bottom: -100px;
      left: 55%;
      margin-left: -160px;
      opacity: 0;
      transition: opacity 0.3s;
    }

    .tooltiptext::after {
      position: absolute;
      top: 20%;
      left: 55%;
      margin-left: -5px;
    }

    .tooltip.hovered .tooltiptext {
      visibility: visible;
      opacity: 1;
    }

    .wrapper {
      display: flex;
      flex-wrap: nowrap;
    }
  </style>

  <script>
    //TICKER ANIMATION
    function tooltipAnimation() {
      const tooltipItems = document.querySelectorAll(".tooltip");

      tooltipItems.forEach((tooltipItem) => {
        const tooltipText = tooltipItem.querySelector(".tooltiptext");
        const logoDiv = tooltipItem.querySelector(".logo");

        logoDiv.addEventListener("mouseenter", () => {
          if (!tooltipItem.classList.contains("hovered") && tooltipText) {
            resetTooltips();
            tooltipItem.classList.add("hovered");
            reduceSpeed();
            tooltipText.style.opacity = "1";
          }
        });

        tooltipItem.addEventListener("mouseleave", () => {
          tooltipItem.classList.remove("hovered");
          resetSpeed();
          tooltipText.style.opacity = "";
        });
      });
    }

    function resetTooltips() {
      const tooltipItems = document.querySelectorAll(".tooltip");

      tooltipItems.forEach((tooltipItem) => {
        tooltipItem.classList.remove("hovered");
      });
    }

    function reduceSpeed() {
      const tooltipItems = document.querySelectorAll(".tooltip");

      tooltipItems.forEach((tooltipItem) => {
        tooltipItem.style.animationPlayState = "paused";
      });
    }

    function resetSpeed() {
      const tooltipItems = document.querySelectorAll(".tooltip");

      tooltipItems.forEach((tooltipItem) => {
        tooltipItem.style.animationPlayState = "running";
      });
    }

    // Call the tooltipAnimation function to initialize the event listeners
    tooltipAnimation();
  </script>
</body>

</html>
@endsection
