<!doctype html>
<html><head>
<meta charset="utf-8">
<style type="text/css">
            #container{
               width:800px;
               margin:0 auto;
            }
 
            #search{
               width:700px;
               padding:10px;
            }
 
            #button{
               display: block;
               width: 100px;
               height:30px;
               border:solid #366FEB 1px;
               background: #91B2FA;
            }
 
            ul{
                margin-left:-40px;
            }
 
            ul li{
                list-style-type: none;
                border-bottom: dotted 1px black;
              height: 50px;
            }
 
            li:hover{
                background: #A592E8;
            }
 
            a{
                text-decoration: none;
              font-size: 18px;
            }
        </style>
</head>
<body>
        <div id="container">
             <input type="text" id="search" placeholder="material a buscar"/>
             <input type="button" id="button" value="Search" />
             <ul id="result"></ul>
        </div>
  </body>
<script src="jquery.min.js" type="text/javascript"></script>
<script src="ajax.js" type="text/javascript"></script>
        
</html>