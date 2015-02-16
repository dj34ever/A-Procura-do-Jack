<!DOCTYPE html>
<!--
Description: What this script does
Version: 1.0.0
Date: 00/00/0000
Author: night8ug / email: <webrabit.63@gmail.com>
License: Do not share or use
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" media="screen" type="text/css" href="css/testcss.css" />
    </head>
    <body>
        <div id="menu">
            <input type="image" src="images/star.jpg" id="menu_1" alt="bt1" onclick="f1(this)" />
            <input type="image" src="images/star.jpg" id="menu_2" alt="bt2" onclick="f2(this)" />
            <input type="image" src="images/star.jpg" id="menu_3" alt="bt3" onclick="f3(this)" />
        </div>
        <div id="m">
            <input type="button" id="b1" value="Butão A" />
            <input type="button" id="b2" value="Butão B" />
            <input type="button" id="b3" value="Butão C" />
        </div>
        <script>
            function f1(){
                var elem1 = document.getElementById("menu_1");
                var elem2 = document.getElementById("menu_2");
                var elem3 = document.getElementById("menu_3");
                
                elem1.setAttribute("src","images/rewind.png");
                elem2.setAttribute("src","images/star.jpg");
                elem3.setAttribute("src","images/star.jpg");
            }
            function f2(){
                var elem1 = document.getElementById("menu_1");
                var elem2 = document.getElementById("menu_2");
                var elem3 = document.getElementById("menu_3");
                
                elem1.setAttribute("src","images/star.jpg");
                elem2.setAttribute("src","images/rewind.png");
                elem3.setAttribute("src","images/star.jpg");
            }
            function f3(){
                var elem1 = document.getElementById("menu_1");
                var elem2 = document.getElementById("menu_2");
                var elem3 = document.getElementById("menu_3");
                
                elem1.setAttribute("src","images/star.jpg");
                elem2.setAttribute("src","images/star.jpg");
                elem3.setAttribute("src","images/rewind.png");
            }
            
        </script>
    </body>
</html>
