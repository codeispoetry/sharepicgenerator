const frame = {
    svg: draw.circle(),

    draw() {

        frame.svg.remove();

        const t = draw.width() * $('#framewidth').val() / 1080; // thickness of frame

        const w = draw.width();
        const h = draw.height();

        this.svg = draw.polygon(`
           0,0 ${w},0 ${w},${h} 0,${h}
           0, ${t} ${t},${t} ${t},${h - t} ${w - t}, ${h - t} ${w - t}, ${t}, 0, ${t}
            `).fill('#8abf2c');

        frame.svg.front();
        bayernlogo.svg.front();
        floating.svg.front();
    },

};

$('#framewidth').on('input propertychange', () => {
    frame.draw();
}  );
