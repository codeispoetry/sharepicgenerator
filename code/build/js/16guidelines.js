const sharepic = document.querySelector('#canvas svg');
const guidelines = document.querySelectorAll('.guideline');

const guidelineX1 = document.getElementById('guideline-x1');
const guidelineX2 = document.getElementById('guideline-x2');
const guidelineY1 = document.getElementById('guideline-y1');
const guidelineY2 = document.getElementById('guideline-y2');

sharepic.addEventListener('mouseenter', (e) => {
    guidelines.forEach((guideline) => {
        guideline.classList.remove('d-none');
    });
});

sharepic.addEventListener('mouseleave', (e) => {        
    guidelines.forEach((guideline) => {
        guideline.classList.add('d-none');
    });
    $('#mouse-position').text('&nbsp;');
});

sharepic.addEventListener('mousemove', (e) => {
    const x = e.offsetX;
    const y = e.offsetY;
    const width = sharepic.getBoundingClientRect().width;
    const height = sharepic.getBoundingClientRect().height;
    const space = 25;
    
   guidelineX1.style.left= x + 'px';
   guidelineX2.style.left= x + 'px';

   guidelineX1.style.height= ( y - space ) + 'px';
   guidelineX2.style.top= ( y + space ) + 'px';
   guidelineX2.style.height= (height - y - space ) + 'px';

   guidelineY1.style.top= y + 'px';
   guidelineY2.style.top= y + 'px';

   guidelineY1.style.width= ( x - space ) + 'px';
   guidelineY2.style.left= ( x + space ) + 'px';
   guidelineY2.style.width= ( width - x - space ) + 'px';

   $('#mouse-position').text('x: ' + x + ', y: ' + y);
});
