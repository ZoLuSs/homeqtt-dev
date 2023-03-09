<?php
require_once('config/session.php');
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>HomeQTT - Home</title>
    <script src="/js/socketio/socket.io.min.js"></script>
</head>
<body>
<?php require_once("header.php");?>
<div class="segment">
    <div class="cards-container">
        <div class="card light">
            <div class="card-title"><span>Lampe de chevet</span></div>
            <div class="card-container action">
                <svg viewBox="-4 0 24 24" id="meteor-icon-kit__regular-lightbulb" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                    <g id="SVGRepo_iconCarrier">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.8376 16V12.5L11.4429 12.0461C13.3647 10.6047 14.1486 8.09524 13.3889 5.81623C12.6293 3.53721 10.4965 2 8.0942 2H7.581C5.17873 2 3.04596 3.53721 2.28629 5.81623C1.52707 8.09389 2.31257 10.6017 4.23547 12.0393L4.83761 12.4895V16H10.8376zM12.8376 16C12.8376 17.1046 11.9422 18 10.8376 18H4.83761C3.73304 18 2.83761 17.1046 2.83761 16V13.4862C0.37065 11.5108 -0.6161 8.19886 0.38893 5.18377C1.42083 2.08807 4.31787 0 7.581 0H8.0942C11.3573 0 14.2544 2.08807 15.2863 5.18377C16.2921 8.20132 15.3058 11.5163 12.8376 13.495V16zM4.83761 21C4.28532 21 3.83761 20.5523 3.83761 20C3.83761 19.4477 4.28532 19 4.83761 19H10.8376C11.3899 19 11.8376 19.4477 11.8376 20C11.8376 20.5523 11.3899 21 10.8376 21H4.83761zM5.83761 24C5.28532 24 4.83761 23.5523 4.83761 23C4.83761 22.4477 5.28532 22 5.83761 22H9.8376C10.3899 22 10.8376 22.4477 10.8376 23C10.8376 23.5523 10.3899 24 9.8376 24H5.83761z"/>
                    </g>
                </svg>
            </div>
        </div>
        <div class="card light active">
            <div class="card-title"><span>Petite lumière</span></div>
            <div class="card-container action">
                <svg viewBox="-4 0 24 24" id="meteor-icon-kit__regular-lightbulb" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                    <g id="SVGRepo_iconCarrier">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.8376 16V12.5L11.4429 12.0461C13.3647 10.6047 14.1486 8.09524 13.3889 5.81623C12.6293 3.53721 10.4965 2 8.0942 2H7.581C5.17873 2 3.04596 3.53721 2.28629 5.81623C1.52707 8.09389 2.31257 10.6017 4.23547 12.0393L4.83761 12.4895V16H10.8376zM12.8376 16C12.8376 17.1046 11.9422 18 10.8376 18H4.83761C3.73304 18 2.83761 17.1046 2.83761 16V13.4862C0.37065 11.5108 -0.6161 8.19886 0.38893 5.18377C1.42083 2.08807 4.31787 0 7.581 0H8.0942C11.3573 0 14.2544 2.08807 15.2863 5.18377C16.2921 8.20132 15.3058 11.5163 12.8376 13.495V16zM4.83761 21C4.28532 21 3.83761 20.5523 3.83761 20C3.83761 19.4477 4.28532 19 4.83761 19H10.8376C11.3899 19 11.8376 19.4477 11.8376 20C11.8376 20.5523 11.3899 21 10.8376 21H4.83761zM5.83761 24C5.28532 24 4.83761 23.5523 4.83761 23C4.83761 22.4477 5.28532 22 5.83761 22H9.8376C10.3899 22 10.8376 22.4477 10.8376 23C10.8376 23.5523 10.3899 24 9.8376 24H5.83761z"/>
                    </g>
                </svg>
            </div>
        </div>
        <div class="card">
            <div class="card-title"><span>Station</span></div>
            <div class="card-container 2-data">
                <div class="card-icon-container dual-icon">
                    <svg viewBox="0 0 56 56" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M 25.0117 54.0391 C 31.7617 54.0391 37.2461 48.5547 37.2461 41.8047 C 37.2461 38.2422 35.7696 35.125 32.9805 32.5938 C 32.4649 32.125 32.3476 31.8672 32.3476 31.1641 L 32.3945 10.1172 C 32.3945 5.2187 29.4180 1.9609 25.0117 1.9609 C 20.5820 1.9609 17.6055 5.2187 17.6055 10.1172 L 17.6289 31.1641 C 17.6289 31.8672 17.5117 32.125 17.0196 32.5938 C 14.2070 35.125 12.7539 38.2422 12.7539 41.8047 C 12.7539 48.5547 18.2149 54.0391 25.0117 54.0391 Z M 25.0117 50.6407 C 20.1367 50.6407 16.1758 46.6563 16.1758 41.8047 C 16.1758 38.8750 17.5586 36.2266 20.0430 34.5625 C 20.7696 34.0703 21.0508 33.625 21.0508 32.6641 L 21.0508 10.2578 C 21.0508 7.3047 22.6680 5.4063 25.0117 5.4063 C 27.3320 5.4063 28.9258 7.3047 28.9258 10.2578 L 28.9258 32.6641 C 28.9258 33.625 29.2070 34.0703 29.9336 34.5625 C 32.4180 36.2266 33.8008 38.8750 33.8008 41.8047 C 33.8008 46.6563 29.8633 50.6407 25.0117 50.6407 Z M 36.7539 10.5625 L 41.8633 10.5625 C 42.6836 10.5625 43.2461 9.9297 43.2461 9.2031 C 43.2461 8.4766 42.6836 7.8438 41.8633 7.8438 L 36.7539 7.8438 C 35.9336 7.8438 35.3711 8.4766 35.3711 9.2031 C 35.3711 9.9297 35.9336 10.5625 36.7539 10.5625 Z M 36.7539 17.1485 L 41.8633 17.1485 C 42.6836 17.1485 43.2461 16.5156 43.2461 15.7891 C 43.2461 15.0625 42.6836 14.4297 41.8633 14.4297 L 36.7539 14.4297 C 35.9336 14.4297 35.3711 15.0625 35.3711 15.7891 C 35.3711 16.5156 35.9336 17.1485 36.7539 17.1485 Z M 24.9883 47.4766 C 28.1289 47.4766 30.6602 44.9453 30.6602 41.7813 C 30.6602 39.5781 29.4180 37.7734 27.6133 36.7891 C 26.8633 36.3907 26.6055 36.1094 26.6055 34.9609 L 26.6055 22.5156 C 26.6055 21.2969 25.9023 20.5703 24.9883 20.5703 C 24.0976 20.5703 23.3711 21.2969 23.3711 22.5156 L 23.3711 34.9609 C 23.3711 36.1094 23.1133 36.3907 22.3633 36.7891 C 20.5586 37.7734 19.3164 39.5781 19.3164 41.7813 C 19.3164 44.9453 21.8476 47.4766 24.9883 47.4766 Z M 36.7539 23.7344 L 41.8633 23.7344 C 42.6836 23.7344 43.2461 23.1016 43.2461 22.375 C 43.2461 21.6485 42.6836 20.9922 41.8633 20.9922 L 36.7539 20.9922 C 35.9336 20.9922 35.3711 21.6485 35.3711 22.375 C 35.3711 23.1016 35.9336 23.7344 36.7539 23.7344 Z M 36.7539 30.3203 L 41.8633 30.3203 C 42.6836 30.3203 43.2461 29.6641 43.2461 28.9375 C 43.2461 28.2109 42.6836 27.5782 41.8633 27.5782 L 36.7539 27.5782 C 35.9336 27.5782 35.3711 28.2109 35.3711 28.9375 C 35.3711 29.6641 35.9336 30.3203 36.7539 30.3203 Z"></path>
                        </g>
                    </svg>
                    <svg viewBox="5 7 52 52" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:serif="http://www.serif.com/" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_iconCarrier">
                            <g id="Expanded">
                                <path d="M35.776,53.677c-0.547,-1.558 -2.032,-2.677 -3.776,-2.677c-2.208,-0 -4,1.792 -4,4c0,2.208 1.792,4 4,4c1.977,0 3.621,-1.437 3.943,-3.323c11.373,-1.884 20.057,-11.774 20.057,-23.677c0,-2.546 -0.398,-5.001 -1.134,-7.304c-0.168,-0.526 -0.731,-0.817 -1.257,-0.649c-0.526,0.168 -0.816,0.732 -0.648,1.257c0.675,2.112 1.039,4.362 1.039,6.696c0,10.856 -7.879,19.886 -18.224,21.677Zm-3.776,-0.677c1.104,-0 2,0.896 2,2c0,1.104 -0.896,2 -2,2c-1.104,0 -2,-0.896 -2,-2c0,-1.104 0.896,-2 2,-2Zm-23.984,-20.122c0.375,10.42 7.408,19.156 16.968,22.078c0.528,0.162 1.087,-0.136 1.249,-0.664c0.161,-0.528 -0.137,-1.087 -0.664,-1.248c-8.744,-2.673 -15.181,-10.651 -15.552,-20.175c1.716,-0.45 2.983,-2.013 2.983,-3.869c0,-2.208 -1.792,-4 -4,-4c-2.208,-0 -4,1.792 -4,4c0,1.868 1.283,3.439 3.016,3.878Zm27.915,10.299c0.696,0.21 1.434,0.323 2.199,0.323c4.203,-0 7.615,-3.413 7.615,-7.616c0,-5.628 -3.413,-10.753 -6.876,-14.557c-0.301,-0.331 -0.786,-0.422 -1.186,-0.222c-0.401,0.201 -0.62,0.642 -0.536,1.082c0.45,2.362 -0.346,4.008 -1.469,5.42c-1.749,-3.673 -4.272,-6.993 -6.809,-9.78c-0.301,-0.331 -0.786,-0.422 -1.186,-0.222c-0.401,0.201 -0.62,0.642 -0.536,1.082c0.813,4.265 -1.282,6.855 -3.517,9.228c-1.252,1.328 -2.557,2.593 -3.552,3.985c-1.092,1.525 -1.823,3.198 -1.823,5.225c-0,5.45 4.424,9.875 9.875,9.875c3.17,0 5.993,-1.497 7.801,-3.823Zm-6.633,-21.792c3.572,4.387 6.707,9.82 6.707,15.74c-0,4.346 -3.529,7.875 -7.875,7.875c-4.347,0 -7.875,-3.529 -7.875,-7.875c-0,-1.579 0.599,-2.873 1.449,-4.061c0.946,-1.322 2.193,-2.516 3.382,-3.778c2.062,-2.19 3.941,-4.567 4.213,-7.9l-0.001,-0.001Zm-0.996,10.922l-2.376,8.868c-0.143,0.533 0.174,1.082 0.707,1.225c0.533,0.143 1.082,-0.174 1.225,-0.707l2.376,-8.868c0.143,-0.533 -0.174,-1.082 -0.707,-1.225c-0.533,-0.143 -1.082,0.174 -1.225,0.707Zm8.734,9.086c0.353,0.07 0.719,0.107 1.094,0.107c3.099,-0 5.615,-2.516 5.615,-5.616c0,-4.145 -2.094,-7.961 -4.563,-11.1c-0.322,1.968 -1.385,3.49 -2.625,4.875c0.903,2.379 1.448,4.882 1.448,7.466c-0,1.528 -0.348,2.976 -0.969,4.268Zm-13.446,-0.303c0.878,0 1.591,-0.712 1.591,-1.59c-0,-0.878 -0.713,-1.59 -1.591,-1.59c-0.877,-0 -1.59,0.712 -1.59,1.59c-0,0.878 0.713,1.59 1.59,1.59Zm0,-2c0.226,0 0.41,0.184 0.41,0.41c-0,0.226 -0.184,0.41 -0.41,0.41c-0.226,-0 -0.409,-0.184 -0.409,-0.41c-0,-0.226 0.183,-0.41 0.409,-0.41Zm8.91,-2.5c0.878,0 1.59,-0.712 1.59,-1.59c0,-0.878 -0.712,-1.59 -1.59,-1.59c-0.878,-0 -1.59,0.712 -1.59,1.59c-0,0.878 0.712,1.59 1.59,1.59Zm0,-2c0.226,0 0.41,0.184 0.41,0.41c-0,0.226 -0.184,0.41 -0.41,0.41c-0.226,-0 -0.41,-0.184 -0.41,-0.41c0,-0.226 0.184,-0.41 0.41,-0.41Zm-23.5,-7.59c1.104,-0 2,0.896 2,2c0,1.104 -0.896,2 -2,2c-1.104,-0 -2,-0.896 -2,-2c0,-1.104 0.896,-2 2,-2Zm38.759,-10.344c-0.477,0.659 -0.759,1.469 -0.759,2.344c0,2.208 1.792,4 4,4c2.208,0 4,-1.792 4,-4c0,-2.208 -1.792,-4 -4,-4c-0.606,-0 -1.181,0.135 -1.695,0.377c-4.368,-4.546 -10.509,-7.377 -17.305,-7.377c-9.914,-0 -18.432,6.024 -22.09,14.608c-0.216,0.508 0.021,1.096 0.528,1.312c0.508,0.216 1.096,-0.02 1.312,-0.528c3.354,-7.869 11.162,-13.392 20.25,-13.392c6.177,-0 11.762,2.551 15.759,6.656Zm3.241,0.344c1.104,-0 2,0.896 2,2c0,1.104 -0.896,2 -2,2c-1.104,0 -2,-0.896 -2,-2c0,-1.104 0.896,-2 2,-2Z"></path>
                            </g>
                        </g>
                    </svg>
                </div>
                <div class="card-value-container">
                    <span>21.3°C</span>
                    <span>57.2%</span>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-title"><span>Température</span></div>
            <div class="card-container">
                <div class="card-icon-container">
                    <svg viewBox="12 1 32 54" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M 25.0117 54.0391 C 31.7617 54.0391 37.2461 48.5547 37.2461 41.8047 C 37.2461 38.2422 35.7696 35.125 32.9805 32.5938 C 32.4649 32.125 32.3476 31.8672 32.3476 31.1641 L 32.3945 10.1172 C 32.3945 5.2187 29.4180 1.9609 25.0117 1.9609 C 20.5820 1.9609 17.6055 5.2187 17.6055 10.1172 L 17.6289 31.1641 C 17.6289 31.8672 17.5117 32.125 17.0196 32.5938 C 14.2070 35.125 12.7539 38.2422 12.7539 41.8047 C 12.7539 48.5547 18.2149 54.0391 25.0117 54.0391 Z M 25.0117 50.6407 C 20.1367 50.6407 16.1758 46.6563 16.1758 41.8047 C 16.1758 38.8750 17.5586 36.2266 20.0430 34.5625 C 20.7696 34.0703 21.0508 33.625 21.0508 32.6641 L 21.0508 10.2578 C 21.0508 7.3047 22.6680 5.4063 25.0117 5.4063 C 27.3320 5.4063 28.9258 7.3047 28.9258 10.2578 L 28.9258 32.6641 C 28.9258 33.625 29.2070 34.0703 29.9336 34.5625 C 32.4180 36.2266 33.8008 38.8750 33.8008 41.8047 C 33.8008 46.6563 29.8633 50.6407 25.0117 50.6407 Z M 36.7539 10.5625 L 41.8633 10.5625 C 42.6836 10.5625 43.2461 9.9297 43.2461 9.2031 C 43.2461 8.4766 42.6836 7.8438 41.8633 7.8438 L 36.7539 7.8438 C 35.9336 7.8438 35.3711 8.4766 35.3711 9.2031 C 35.3711 9.9297 35.9336 10.5625 36.7539 10.5625 Z M 36.7539 17.1485 L 41.8633 17.1485 C 42.6836 17.1485 43.2461 16.5156 43.2461 15.7891 C 43.2461 15.0625 42.6836 14.4297 41.8633 14.4297 L 36.7539 14.4297 C 35.9336 14.4297 35.3711 15.0625 35.3711 15.7891 C 35.3711 16.5156 35.9336 17.1485 36.7539 17.1485 Z M 24.9883 47.4766 C 28.1289 47.4766 30.6602 44.9453 30.6602 41.7813 C 30.6602 39.5781 29.4180 37.7734 27.6133 36.7891 C 26.8633 36.3907 26.6055 36.1094 26.6055 34.9609 L 26.6055 22.5156 C 26.6055 21.2969 25.9023 20.5703 24.9883 20.5703 C 24.0976 20.5703 23.3711 21.2969 23.3711 22.5156 L 23.3711 34.9609 C 23.3711 36.1094 23.1133 36.3907 22.3633 36.7891 C 20.5586 37.7734 19.3164 39.5781 19.3164 41.7813 C 19.3164 44.9453 21.8476 47.4766 24.9883 47.4766 Z M 36.7539 23.7344 L 41.8633 23.7344 C 42.6836 23.7344 43.2461 23.1016 43.2461 22.375 C 43.2461 21.6485 42.6836 20.9922 41.8633 20.9922 L 36.7539 20.9922 C 35.9336 20.9922 35.3711 21.6485 35.3711 22.375 C 35.3711 23.1016 35.9336 23.7344 36.7539 23.7344 Z M 36.7539 30.3203 L 41.8633 30.3203 C 42.6836 30.3203 43.2461 29.6641 43.2461 28.9375 C 43.2461 28.2109 42.6836 27.5782 41.8633 27.5782 L 36.7539 27.5782 C 35.9336 27.5782 35.3711 28.2109 35.3711 28.9375 C 35.3711 29.6641 35.9336 30.3203 36.7539 30.3203 Z"></path>
                        </g>
                    </svg>
                </div>
                <div class="card-value-container">
                    <span>21.34°C</span>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-title"><span>Humidité</span></div>
            <div class="card-container">
                <div class="card-icon-container">
                    <svg viewBox="5 7 52 52" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:serif="http://www.serif.com/" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_iconCarrier">
                            <g id="Expanded">
                                <path d="M35.776,53.677c-0.547,-1.558 -2.032,-2.677 -3.776,-2.677c-2.208,-0 -4,1.792 -4,4c0,2.208 1.792,4 4,4c1.977,0 3.621,-1.437 3.943,-3.323c11.373,-1.884 20.057,-11.774 20.057,-23.677c0,-2.546 -0.398,-5.001 -1.134,-7.304c-0.168,-0.526 -0.731,-0.817 -1.257,-0.649c-0.526,0.168 -0.816,0.732 -0.648,1.257c0.675,2.112 1.039,4.362 1.039,6.696c0,10.856 -7.879,19.886 -18.224,21.677Zm-3.776,-0.677c1.104,-0 2,0.896 2,2c0,1.104 -0.896,2 -2,2c-1.104,0 -2,-0.896 -2,-2c0,-1.104 0.896,-2 2,-2Zm-23.984,-20.122c0.375,10.42 7.408,19.156 16.968,22.078c0.528,0.162 1.087,-0.136 1.249,-0.664c0.161,-0.528 -0.137,-1.087 -0.664,-1.248c-8.744,-2.673 -15.181,-10.651 -15.552,-20.175c1.716,-0.45 2.983,-2.013 2.983,-3.869c0,-2.208 -1.792,-4 -4,-4c-2.208,-0 -4,1.792 -4,4c0,1.868 1.283,3.439 3.016,3.878Zm27.915,10.299c0.696,0.21 1.434,0.323 2.199,0.323c4.203,-0 7.615,-3.413 7.615,-7.616c0,-5.628 -3.413,-10.753 -6.876,-14.557c-0.301,-0.331 -0.786,-0.422 -1.186,-0.222c-0.401,0.201 -0.62,0.642 -0.536,1.082c0.45,2.362 -0.346,4.008 -1.469,5.42c-1.749,-3.673 -4.272,-6.993 -6.809,-9.78c-0.301,-0.331 -0.786,-0.422 -1.186,-0.222c-0.401,0.201 -0.62,0.642 -0.536,1.082c0.813,4.265 -1.282,6.855 -3.517,9.228c-1.252,1.328 -2.557,2.593 -3.552,3.985c-1.092,1.525 -1.823,3.198 -1.823,5.225c-0,5.45 4.424,9.875 9.875,9.875c3.17,0 5.993,-1.497 7.801,-3.823Zm-6.633,-21.792c3.572,4.387 6.707,9.82 6.707,15.74c-0,4.346 -3.529,7.875 -7.875,7.875c-4.347,0 -7.875,-3.529 -7.875,-7.875c-0,-1.579 0.599,-2.873 1.449,-4.061c0.946,-1.322 2.193,-2.516 3.382,-3.778c2.062,-2.19 3.941,-4.567 4.213,-7.9l-0.001,-0.001Zm-0.996,10.922l-2.376,8.868c-0.143,0.533 0.174,1.082 0.707,1.225c0.533,0.143 1.082,-0.174 1.225,-0.707l2.376,-8.868c0.143,-0.533 -0.174,-1.082 -0.707,-1.225c-0.533,-0.143 -1.082,0.174 -1.225,0.707Zm8.734,9.086c0.353,0.07 0.719,0.107 1.094,0.107c3.099,-0 5.615,-2.516 5.615,-5.616c0,-4.145 -2.094,-7.961 -4.563,-11.1c-0.322,1.968 -1.385,3.49 -2.625,4.875c0.903,2.379 1.448,4.882 1.448,7.466c-0,1.528 -0.348,2.976 -0.969,4.268Zm-13.446,-0.303c0.878,0 1.591,-0.712 1.591,-1.59c-0,-0.878 -0.713,-1.59 -1.591,-1.59c-0.877,-0 -1.59,0.712 -1.59,1.59c-0,0.878 0.713,1.59 1.59,1.59Zm0,-2c0.226,0 0.41,0.184 0.41,0.41c-0,0.226 -0.184,0.41 -0.41,0.41c-0.226,-0 -0.409,-0.184 -0.409,-0.41c-0,-0.226 0.183,-0.41 0.409,-0.41Zm8.91,-2.5c0.878,0 1.59,-0.712 1.59,-1.59c0,-0.878 -0.712,-1.59 -1.59,-1.59c-0.878,-0 -1.59,0.712 -1.59,1.59c-0,0.878 0.712,1.59 1.59,1.59Zm0,-2c0.226,0 0.41,0.184 0.41,0.41c-0,0.226 -0.184,0.41 -0.41,0.41c-0.226,-0 -0.41,-0.184 -0.41,-0.41c0,-0.226 0.184,-0.41 0.41,-0.41Zm-23.5,-7.59c1.104,-0 2,0.896 2,2c0,1.104 -0.896,2 -2,2c-1.104,-0 -2,-0.896 -2,-2c0,-1.104 0.896,-2 2,-2Zm38.759,-10.344c-0.477,0.659 -0.759,1.469 -0.759,2.344c0,2.208 1.792,4 4,4c2.208,0 4,-1.792 4,-4c0,-2.208 -1.792,-4 -4,-4c-0.606,-0 -1.181,0.135 -1.695,0.377c-4.368,-4.546 -10.509,-7.377 -17.305,-7.377c-9.914,-0 -18.432,6.024 -22.09,14.608c-0.216,0.508 0.021,1.096 0.528,1.312c0.508,0.216 1.096,-0.02 1.312,-0.528c3.354,-7.869 11.162,-13.392 20.25,-13.392c6.177,-0 11.762,2.551 15.759,6.656Zm3.241,0.344c1.104,-0 2,0.896 2,2c0,1.104 -0.896,2 -2,2c-1.104,0 -2,-0.896 -2,-2c0,-1.104 0.896,-2 2,-2Z"></path>
                            </g>
                        </g>
                    </svg>
                </div>
                <div class="card-value-container">
                    <span>57.2%</span>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-title"><span>Consommation totale</span></div>
            <div class="card-container">
                <div class="card-icon-container">
                    <svg viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M829.44 911.36c45.245 0 81.92-36.675 81.92-81.92V194.56c0-45.245-36.675-81.92-81.92-81.92H194.56c-45.245 0-81.92 36.675-81.92 81.92v634.88c0 45.245 36.675 81.92 81.92 81.92h634.88zm0 40.96H194.56c-67.866 0-122.88-55.014-122.88-122.88V194.56c0-67.866 55.014-122.88 122.88-122.88h634.88c67.866 0 122.88 55.014 122.88 122.88v634.88c0 67.866-55.014 122.88-122.88 122.88z"></path><path d="M727.746 234.526l-.358.247c.12-.078.239-.16.358-.247zm-304.56 198.992l53.506 34.806c9.143 5.947 12.02 18.016 6.545 27.449L322.853 772.067l277.96-181.589-53.507-34.807c-9.143-5.947-12.02-18.016-6.545-27.449l160.378-276.284-277.953 181.579zm14.854 58.527l-63.524-41.323c-12.402-8.068-12.42-26.221-.033-34.313L704.13 201.06c29.158-20.549 66.411 12.954 48.276 44.151l-166.448 286.74 63.524 41.323c12.402 8.068 12.42 26.221.034 34.313L319.883 822.934c-29.153 20.564-66.398-12.925-48.29-44.148l166.448-286.74z"></path>
                        </g>
                    </svg>
                </div>
                <div class="card-value-container">
                    <span>32567 kWh</span>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-title"><span>Puissance instantané</span></div>
            <div class="card-container">
                <div class="card-icon-container">
                    <svg viewBox="0 0 56 56" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M 27.9999 51.9063 C 41.0546 51.9063 51.9063 41.0781 51.9063 28 C 51.9063 14.9453 41.0312 4.0937 27.9765 4.0937 C 14.8983 4.0937 4.0937 14.9453 4.0937 28 C 4.0937 41.0781 14.9218 51.9063 27.9999 51.9063 Z M 27.9999 47.9219 C 16.9374 47.9219 8.1014 39.0625 8.1014 28 C 8.1014 16.9609 16.9140 8.0781 27.9765 8.0781 C 39.0155 8.0781 47.8983 16.9609 47.9219 28 C 47.9454 39.0625 39.0390 47.9219 27.9999 47.9219 Z M 27.9765 17.3828 C 29.2421 17.3828 30.2733 16.3281 30.2733 15.0859 C 30.2733 13.7968 29.2421 12.7890 27.9765 12.7890 C 26.7109 12.7890 25.6796 13.7968 25.6796 15.0859 C 25.6796 16.3281 26.7109 17.3828 27.9765 17.3828 Z M 34.7265 19.4688 C 35.9921 19.4688 37.0234 18.4141 37.0234 17.1484 C 37.0234 15.8828 35.9921 14.8281 34.7265 14.8281 C 33.4609 14.8281 32.4296 15.8828 32.4296 17.1484 C 32.4296 18.4141 33.4609 19.4688 34.7265 19.4688 Z M 20.9218 19.4688 C 22.1874 19.4688 23.2187 18.4141 23.2187 17.1484 C 23.2187 15.8828 22.1874 14.8516 20.9218 14.8516 C 19.6562 14.8516 18.6249 15.8828 18.6249 17.1484 C 18.6249 18.4141 19.6562 19.4688 20.9218 19.4688 Z M 16.3046 24.4141 C 17.5702 24.4141 18.6014 23.3828 18.6014 22.1172 C 18.6014 20.8281 17.5702 19.7968 16.3046 19.7968 C 15.0390 19.7968 14.0077 20.8281 14.0077 22.1172 C 14.0077 23.3828 15.0390 24.4141 16.3046 24.4141 Z M 39.3436 24.4375 C 40.6093 24.4375 41.6405 23.4063 41.6405 22.1406 C 41.6405 20.8516 40.6093 19.8203 39.3436 19.8203 C 38.0780 19.8203 37.0468 20.8516 37.0468 22.1406 C 37.0468 23.4063 38.0780 24.4375 39.3436 24.4375 Z M 27.9765 42.2500 C 30.0390 42.2500 31.7030 40.5859 31.7030 38.5 C 31.7030 37 30.8124 35.7109 29.5234 35.1250 L 29.5234 24.1563 C 29.5234 23.2656 28.8202 22.5625 27.9765 22.5625 C 27.1327 22.5625 26.4296 23.2656 26.4296 24.1563 L 26.4296 35.1250 C 25.1405 35.7109 24.2499 37 24.2499 38.5 C 24.2499 40.5859 25.8905 42.2500 27.9765 42.2500 Z"></path>
                    </g>
                </svg>
                </div>
                <div class="card-value-container">
                    <span>770 VA</span>
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="modal" id="modal">
        <div class="modal-container">
            <span class="loader"></span>
        </div>
    </div>
</body>
<?php if(isset($form_url) && !empty($form_url)){ ?>
<script>
document.getElementById("submit").addEventListener("click", sendForm);
loading = document.getElementById("modal");
function sendForm() {
    loading.style.display = "flex";
    <?php if(isset($form) && $form){ ?>
        var form = document.getElementById("form");
        var data = new FormData(form);
    <?php } ?>
    fetch("<?php echo $form_url;?>", {
    <?php if(isset($form) && $form){ ?>
        method: "POST",
        body: data
    <?php }else{ ?>
        method: "POST"
    <?php } ?>
    }) .then(response => {
        if (response.status >= 200 && response.status <= 299) {
        <?php if(isset($goto) && !empty($goto)){ ?>
            window.location.href = "<?php echo $goto; ?>";
        <?php } else {?>
            loading.style.display = "none";
        <?php } ?>
        } else {
            loading.style.display = "none";
        }
        return response.json();
    }).then(result=>{console.log(result);});
}
</script>
<?php } ?>
<script>
const token = "<?php 
require_once("config/jwt.php");
$jwt = generate_jwt("payload");
echo $jwt;?>";
const socket = io.connect('http://<?php echo $_SERVER['SERVER_NAME']; ?>:4001', {
  query: {token}
});
</script>
<script src="/js/index.js"></script>
</html>