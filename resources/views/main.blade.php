<!DOCTYPE html>
<html lang="en" ng-app="Cheapest" style="height:100%;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale = 1.0, maximum-scale = 1.0, user-scalable=no">
    <base href="/">

    <title>Coming Soon :: Cheape.st</title>
    <meta name="description" content="Cheape.st helps you find the cheapest prices with a simple search. Coming soon!">
    <meta name="keywords" content="cheapest, cheap, lowest prices, save money">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">

    <link rel="stylesheet" href="{{ url('css/animate.css') }}">
	<link rel="stylesheet" href="{{ url('css/app.css') }}">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-aNUYGqSUL9wG/vP7+cWZ5QOM4gsQou3sBfWRr/8S3R1Lv0rysEmnwsRKMbhiQX/O" crossorigin="anonymous">

	<link href='http://fonts.googleapis.com/css?family=Lato:300' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Lobster:400' rel='stylesheet' type='text/css'>
</head>
<body>
	<div ui-view style="height:100%;" ng-class="stateIsHome() ? 'slideRight' : 'slideLeft'"></div>
	<script src="https://use.typekit.net/fim8wog.js"></script>
	<script>try{Typekit.load({ async: true });}catch(e){}</script>
	<script src="{{ url('js/angular.min.js') }}"></script>
	<script src="{{ url('js/angular-ui-router.min.js') }}"></script>
	<script src="{{ url('js/angular-animate.min.js') }}"></script>
	<script src="{{ url('js/app.js') }}"></script>
</body>
</html>
