/* eslint-disable no-undef */
const gradient = {
  svg: draw.circle(0),

  draw() {
    gradient.svg.remove();

    const fill = draw.gradient('linear', (add) => {
      add.stop({ offset: 0, color: '#46962b', opacity: 0.0 });
      add.stop({ offset: 1, color: '#46962b', opacity: 1 });
    }).from(0, 0).to(0, 1);

    gradient.svg = draw.rect(draw.width(), draw.height() * $('#gradientheight').val() * 0.01)
      .fill(fill);

    gradient.svg.y(draw.height() - gradient.svg.height());

    gradient.svg.front();
    url.svg.front();
    text.svg.front();
    logo.svg.front();
    copyright.svg.front();
  },
};

$('#gradientheight').bind('input propertychange', gradient.draw);
