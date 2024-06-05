(function (global) {
    const ChartHelpers = {
        updateChart: function (chart, data, initialColors) {
            const labels = data.map(item => item.name);
            const counts = data.map(item => item.count);

            chart.data.labels = labels;
            chart.data.datasets[0].data = counts;
            chart.data.datasets[0].backgroundColor = [...initialColors];
            chart.data.datasets[0].borderColor = [...initialColors];
            chart.update();
        },

        resetChart: function (chart, initialColors) {
            chart.data.labels = [];
            chart.data.datasets[0].data = [];
            chart.data.datasets[0].backgroundColor = [...initialColors];
            chart.data.datasets[0].borderColor = [...initialColors];
            chart.update();
        },

        highlightSegment: function (chart, index, initialColors, transparentColors) {
            // Réinitialiser les couleurs avant d'appliquer les nouvelles
            chart.data.datasets[0].backgroundColor = [...initialColors];
            chart.data.datasets[0].borderColor = [...initialColors];

            // Appliquer la transparence aux autres segments
            chart.data.datasets[0].backgroundColor = chart.data.datasets[0].backgroundColor.map((color, i) => i === index ? color : transparentColors[i]);
            chart.data.datasets[0].borderColor = chart.data.datasets[0].borderColor.map((color, i) => i === index ? color : transparentColors[i]);

            chart.update();
        }
    };
    global.ChartHelpers = ChartHelpers;
})(window);
