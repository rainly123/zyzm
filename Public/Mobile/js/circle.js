var circleTo = function (percent, totalTime, circleElm) {
    var r= 29;
    circleElm.setAttribute('r', r);
    var elm = document.querySelector('.percent span'),
        stepResult = 0,
        circleLength = 2 * Math.PI * r,
        stepResultArc = circleLength,
        requestId = 0,
        stepSize = percent / totalTime * 50 / 3,
        stepSizeArc = circleLength * percent / 100 / totalTime * 50 / 3;
    circleElm.style.strokeDasharray = circleLength;
    var drawFrame = function () {
        elm.innerHTML = parseInt(stepResult);
        stepResultArc -= stepSizeArc;
        stepResult += stepSize;

        if (stepResultArc < 0) {
            stepResultArc = 0;
            /*circleElm.classList.add('full');
            document.querySelector('#circle-progress').classList.add('full');*/
        }
        circleElm.style.strokeDashoffset = stepResultArc;

        if (stepResult >= percent) {
            clearTimeout(requestId);
            elm.innerHTML = percent;
            var finalArc = circleLength - circleLength * percent / 100;
            if (finalArc < 0) finalArc = 0;
            circleElm.style.strokeDashoffset = finalArc;
        } else {
            setTimeout(drawFrame, 50 / 3);
        }
    };
    setTimeout(drawFrame, 50 / 3);
};
circleTo(parseInt($('#finish_progress').val()), 2000, $('.circle-progress .circle-animate').get(0));