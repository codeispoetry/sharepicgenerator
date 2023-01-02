const frame = {
    
    svg: draw.circle(),

    thickness: draw.width() * 0.025,
    
    draw() {
        frame.svg.remove();
        frame.svg = draw.group();

        const t = draw.width() * 0.025; // thickness of frame
        const color1 = '#006a52';
        const color2 = '#95c11f';
        const w = draw.width();
        const h = draw.height();
        
        const frame1 = draw.polygon(`
           0,0 ${w},0 ${w},${h} 0,${h}
           0, ${t} ${t},${t} ${t},${h - t} ${w-t}, ${h - t} ${w-t}, ${t}, 0, ${t}
            `).fill(color1);

        const c1 = draw.height() * $('#framebreak').val() / 100;
        const c2 = c1 - 1;
        const c3 = c2 - ( draw.width() * Math.tan( 4 * Math.PI / 180 ) );
        const c4 = c3 - 1;
        const frame2 = draw.polygon(`
           0,${c1} ${t},${c2} ${t},${h - t} ${w-t}, ${h - t} ${w-t}, ${c3} ${w}, ${c4} ${w},${h}
           0,${h}
            `).fill(color2);
        
        frame.svg.add(frame1);
        frame.svg.add(frame2);

       
    },
   
  };

frame.draw();

$('#framebreak').bind('input propertychange', frame.draw);

