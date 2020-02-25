<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>IGNITE | COMING SOON</title>
  <link href="https://fonts.googleapis.com/css?family=Sigmar+One&display=swap" rel="stylesheet">
  <style type="text/css">
    .heading {
	    font-family: 'Sigmar One', cursive;
	    font-size: 70px;
	    font-weight: bold;
	    color: #1ab394;
	    text-shadow: 4px 6px 7px #000000;
	    position: absolute;
	    top: 15%;
	}
	.cup {
	  position: relative;
	  padding: 14px;
	  width: 230px;
	  height: 230px;
	  border: 14px solid #ffa951;
	  border-radius: 100%;
	  background-color: #fc9c45;
	}
	.cup::before {
	  position: absolute;
	  top: 50%;
	  left: 50%;
	  z-index: 2;
	  width: 153px;
	  height: 153px;
	  border-radius: 100%;
	  border: 3px solid transparent;
	  border-left-color: #77665d;
	  -webkit-transform: translate(-50%, -50%) rotate(-45deg);
	          transform: translate(-50%, -50%) rotate(-45deg);
	  content: '';
	}

	.ear {
	  position: absolute;
	  top: 50%;
	  left: 202px;
	  z-index: -1;
	  -webkit-transform: translateY(-50%) rotate(-40deg);
	          transform: translateY(-50%) rotate(-40deg);
	  -webkit-transform-origin: -101px 50%;
	          transform-origin: -101px 50%;
	  width: 62px;
	  height: 55px;
	  overflow: hidden;
	  background-color: #ffa951;
	}
	.ear::before {
	  display: block;
	  position: absolute;
	  top: 50%;
	  right: 100%;
	  width: 244px;
	  height: 244px;
	  border-radius: 100%;
	  -webkit-transform: translateX(28px) translateY(-50%);
	          transform: translateX(28px) translateY(-50%);
	  background-color: #e49848;
	  content: '';
	}

	.coffee {
	  position: relative;
	  width: 100%;
	  height: 100%;
	  border-radius: 100%;
	  box-shadow: inset 0 0 0 14px #3c2316, inset 0 0 0 28px #432719;
	  background-color: #3f2517;
	}
	.coffee::before, .coffee::after {
	  display: block;
	  position: absolute;
	  top: 14px;
	  left: 14px;
	  width: 83.90804598%;
	  height: 83.90804598%;
	  box-shadow: inset 0 0 0 4.6666666667px #5e3624;
	  border-radius: 100%;
	  opacity: 0;
	  -webkit-transform-origin: 50% 50%;
	          transform-origin: 50% 50%;
	  -webkit-animation: dribb ease-out infinite 3s;
	          animation: dribb ease-out infinite 3s;
	  content: '';
	}
	.coffee::after {
	  -webkit-animation-delay: 1.5s;
	          animation-delay: 1.5s;
	}

	.spill {
	  position: absolute;
	  bottom: -90px;
	  left: 100%;
	  z-index: -1;
	  width: 22px;
	  height: 22px;
	  background-color: #3c2316;
	  border-radius: 100%;
	  box-shadow: -53px -28px 0 5px #3c2316, -20px -150px 0 28px #3c2316, -80px -85px 0 28px #3c2316, -20px -90px 0 35px #3c2316;
	}
	.spill .highlight {
	  position: absolute;
	  border: 2px solid transparent;
	  border-left-color: #77665d;
	  border-radius: 100%;
	  -webkit-transform: rotate(-45deg);
	          transform: rotate(-45deg);
	}
	.spill .highlight:nth-child(1) {
	  top: 50%;
	  left: 50%;
	  width: 18px;
	  height: 18px;
	  -webkit-transform: translate(-50%, -50%) rotate(-45deg);
	          transform: translate(-50%, -50%) rotate(-45deg);
	}
	.spill .highlight:nth-child(2) {
	  top: -31px;
	  left: -56px;
	  width: 28px;
	  height: 28px;
	}
	.spill .highlight:nth-child(3) {
	  bottom: 65px;
	  left: -33px;
	  width: 40px;
	  height: 40px;
	  border-width: 3px;
	  -webkit-transform: rotate(-70deg);
	          transform: rotate(-70deg);
	}

	@-webkit-keyframes dribb {
	  0% {
	    -webkit-transform: scale(0);
	            transform: scale(0);
	    opacity: 1;
	  }
	  60% {
	    opacity: .7;
	  }
	  80%, 100% {
	    -webkit-transform: scale(1);
	            transform: scale(1);
	    opacity: 0;
	  }
	}

	@keyframes dribb {
	  0% {
	    -webkit-transform: scale(0);
	            transform: scale(0);
	    opacity: 1;
	  }
	  60% {
	    opacity: .7;
	  }
	  80%, 100% {
	    -webkit-transform: scale(1);
	            transform: scale(1);
	    opacity: 0;
	  }
	}
	* {
	  box-sizing: border-box;
	}

	html,
	body {
	  margin: 0;
	  padding: 0;
	  height: 100%;
	}

	body {
	  display: -webkit-box;
	  display: flex;
	  -webkit-box-align: center;
	          align-items: center;
	  -webkit-box-pack: center;
	          justify-content: center;
	  background-color: #FFFFFF;
	}
  </style>

</head>
<body>
<div class="heading">COMING SOON</div>

<div class="cup">
  <div class="ear"></div>
  <div class="coffee"></div>
  <div class="spill">
    <div class="highlight"></div>
    <div class="highlight"></div>
    <div class="highlight"></div>
  </div>
</div>


  <script  src="./script.js"></script>

</body>
</html>
