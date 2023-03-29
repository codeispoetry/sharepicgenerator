const frame = {
    svg: draw.circle(),

    draw() {

        frame.svg.remove();

        let t = draw.width() * $('#framewidth').val() / 1080; // thickness of frame

        const w = draw.width();
        const h = draw.height();
        this.svg = draw.group();

        const outer = draw.polygon(`
           0,0 ${w},0 ${w},${h} 0,${h}
           0, ${t} ${t},${t} ${t},${h - t} ${w - t}, ${h - t} ${w - t}, ${t}, 0, ${t}
            `).fill('#8abf2c');

        t = t * 1.1;
        const shadow = draw.polygon(`
            0,0 ${w},0 ${w},${h} 0,${h}
            0, ${t} ${t},${t} ${t},${h - t} ${w - t}, ${h - t} ${w - t}, ${t}, 0, ${t}
             `).fill('#000').opacity(0.7);
        shadow.filterWith(function(add) {
            add.gaussianBlur(30)
        })

        this.svg.add(shadow);
        this.svg.add(outer);

        frame.svg.front();
        bayernlogo.svg.front();
        floating.svg.front();
    },

};

$('#framewidth').on('input propertychange', () => {
    frame.draw();
}  );
