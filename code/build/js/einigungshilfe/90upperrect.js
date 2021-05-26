const upperrect = {

  svg: draw.rect(0, 0),

  draw() {
    upperrect.svg.remove();
    upperrect.svg = draw.group();
    const left = draw.rect(draw.width() * 0.7, draw.height() * 0.035).fill('#73abda');
    const right = draw.rect(draw.width() * 0.3, draw.height() * 0.035).dx(draw.width() * 0.7).fill('#2d81c9');
    upperrect.svg.add(left);
    upperrect.svg.add(right);
},
};

