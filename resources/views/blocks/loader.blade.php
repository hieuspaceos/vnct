<div id="loader-wrapper">
  <div id="loader">
  	<div id="loader2"></div>
  </div>
  <div class="icon-logo"><img  src="<?php echo df1; ?>" style="width:132px ;" ></div>
  <div class="loader-section section-left"></div>
  <div class="loader-section section-right"></div>
  
</div>

<style type="text/css">
  #loader-wrapper {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 9999;
  overflow: hidden;
}
.no-js #loader-wrapper {
  display: none;
}

#loader {
  display: block;
  position:absolute; 
  width: 200px;
  height: 200px;
 left:50%; top:50%; transform:translate(-50%,-50%);
  border-radius: 50%;
 /* border: 3px solid transparent;*/
  border-top-color: #feef9e;
 /* -webkit-animation: spin 1.7s linear infinite;
          animation: spin 1.7s linear infinite;*/
  z-index: 11;
}
#loader2 {
  display: block;
  position:absolute; 
 top: 0px;
    left: 0px;
    right: 0px;
    bottom: 0px;

  border-radius: 50%;
 border: 3px solid transparent;
  border-top-color: #feef9e;
 -webkit-animation: spin 1.7s linear infinite;
 animation: spin 1.7s linear infinite;
  z-index: 12;
}
#loader:before {
  content: "";
  position: absolute;
  top: 10px;
  left: 10px;
  right: 10px;
  bottom: 10px;
  border-radius: 50%;
  border: 3px solid transparent;
  border-top-color: #c18f23;
  -webkit-animation: spin-reverse 0.6s linear infinite;
          animation: spin-reverse 0.6s linear infinite;
}
#loader:after {
  content: "";
  position: absolute;
  top: 20px;
  left: 20px;
  right: 20px;
  bottom: 20px;
  border-radius: 50%;
  border: 3px solid transparent;
  border-top-color: #e3bf58;
  -webkit-animation: spin 1s linear infinite;
          animation: spin 1s linear infinite;
}
.icon-logo{position:absolute; z-index:999; left:50%; top:50%; transform:translate(-50%,-50%)}
@-webkit-keyframes spin {
  0% {
    -webkit-transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
  }
}
@keyframes spin {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-webkit-keyframes spin-reverse {
  0% {
    -webkit-transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(-360deg);
  }
}
@keyframes spin-reverse {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(-360deg);
    transform: rotate(-360deg);
  }
}
#loader-wrapper .loader-section {
  position: fixed;
  top: 0;
  width: 51%;
  height: 100%;
  background: rgba(19,58,79,1);
  z-index: 10;
}

#loader-wrapper .loader-section.section-left {
  left: 0;
}

#loader-wrapper .loader-section.section-right {
  right: 0;
}

/* Loaded styles */
.loaded #loader-wrapper .loader-section.section-left {
  -webkit-transform: translateX(-100%);
          transform: translateX(-100%);
  transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1);
}

.loaded #loader-wrapper .loader-section.section-right {
  -webkit-transform: translateX(100%);
          transform: translateX(100%);
  transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1);
}

.loaded #loader {
  opacity: 0;
  transition: all 0.3s ease-out;
}

.loaded #loader-wrapper {
  visibility: hidden;
  -webkit-transform: translateY(-100%);
          transform: translateY(-100%);
  transition: all 0.3s 1s ease-out;
}
</style>
