<div>

    <form wire:submit="create">
            {{ $this->form }}

            <button type="submit">
                Submit
            </button>
    </form>
    <div id="cal-heatmap" class="bg-red"></div>
    <pre>
        {{ json_encode($heatmapData) }}
    </pre>
</div>
@script
<script>
    let data = [];
const cal = new CalHeatmap();
    // Create a global CalHeatmap instance
//
//
//
//

const tooltip = document.getElementById('tooltip');
const tooltipOptions = {
    events: {
        onClick: (event, timestamp, value) => {
            console.log(`Clicked: ${new Date(timestamp).toDateString()}, Value: ${value}`);
        },
        mouseOver: (event, timestamp, value) => {
            if (value !== null) {
                const date = new Date(timestamp);
                tooltip.innerHTML = `Date: ${date.toDateString()}<br>Value: ${value}`;
                tooltip.style.left = (event.pageX + 10) + 'px';
                tooltip.style.top = (event.pageY + 10) + 'px';
                tooltip.style.opacity = 1;
            }
        },
        mouseOut: () => {
            tooltip.style.opacity = 0;
        }
    }
};
function paintCalendar(dataSource) {
    // First destroy previous instance if it exists
    cal.destroy();

    // Paint the calendar with new data
    cal.paint({
        itemSelector: "#cal-heatmap",
        range: 12,
        domain: {
            type: 'month',
            sort: 'asc',
            label: { text: 'MMM', textAlign: 'start', position: 'top' },
            gutter: 4
        },
        subDomain: {
            type: 'ghDay',
            radius: 2,
            width: 11,
            height: 11,
            gutter: 4,
            label: (timestamp, value) => value !== null ? value.toString() : ""
        },
        data: {
            source: dataSource,
            type: 'json',
            x: 'date',
            y: 'value'
        },
        scale: {
            color: {
                scheme: 'Turbo',
                type: 'sequential',
                domain: [0, 20],
            },
        },
        date: {
            start: new Date("2025-01-01"),
        },
        dynamicDimension: true,
        verticalOrientation: false,
        theme: 'dark',
        ...tooltipOptions
    });
}
paintCalendar(data);
   window.addEventListener('heatmapDataUpdated', function(event) {
    console.log('heatmapDataUpdated event received', event.detail);
    if (event.detail && event.detail.data) {
        // Create a copy of the data to ensure we're working with fresh data
        const data = [...event.detail.data];
        console.log('Painting calendar with updated data', data);

        // Ensure we're executing this in the next tick of the event loop
        setTimeout(() => {

        cat.fill(data)
        }, 0);
    } else {
        console.error('No data provided in the heatmapDataUpdated event');
    }
});
 function update_map(){
        console.log("update_map");

    }
</script>

@endscript

@assets
<head>
<meta charset=utf-8>
<title>blah</title>
<!-- <script src="https://d3js.org/d3.v7.min.js"></script> -->
<!-- v6 is also supported -->
<script src="https://d3js.org/d3.v7.min.js"></script>

<script src="https://unpkg.com/cal-heatmap/dist/cal-heatmap.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/cal-heatmap/dist/cal-heatmap.css">

<style>
.cal-heatmap .ch-day {
  fill: #e0f7fa;
  stroke: #006064;
}
</style>

</head>

@endassets
