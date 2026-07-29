  window.addEventListener('load', function() {
      try {
        const xData = ['2018', '2019', '2020', '2021', '2022', '2023', '2024'];
        const yData = [1200, 1450, 1800, 2400, 3100, 3800, 4200];

        const trace1 = {
          x: xData,
          y: yData,
          type: 'scatter',
          mode: 'lines+markers',
          name: 'Publications',
          line: { color: '#2E7D32', width: 3 },
          marker: { color: '#2E7D32', size: 6 },
          fill: 'tozeroy',
          fillcolor: 'rgba(46, 125, 50, 0.1)'
        };

        const layout = {
          margin: { t: 10, r: 10, b: 30, l: 40 },
          paper_bgcolor: 'rgba(0,0,0,0)',
          plot_bgcolor: 'rgba(0,0,0,0)',
          showlegend: false,
          xaxis: {
            gridcolor: '#f1f5f9',
            tickfont: { size: 10, color: '#94a3b8' }
          },
          yaxis: {
            gridcolor: '#f1f5f9',
            tickfont: { size: 10, color: '#94a3b8' }
          }
        };

        const config = { responsive: true, displayModeBar: false, displaylogo: false };
        Plotly.newPlot('trendChart', [trace1], layout, config);
      } catch(e) {
        console.error("Plotly Error:", e);
      }
    });