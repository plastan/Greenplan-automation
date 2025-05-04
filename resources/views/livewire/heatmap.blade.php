<div>

<head>
<meta charset=utf-8>
<title>2025 Activity Calendar Heatmap</title>
<script src="https://d3js.org/d3.v7.min.js"></script>
<script src="https://unpkg.com/cal-heatmap/dist/cal-heatmap.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/cal-heatmap/dist/cal-heatmap.css">
<style>
    html {
        width: 100%;
        height: 100%;
        background-color: #121212;
        color: #f0f0f0;
        font-family: Arial, sans-serif;
    }
    body {
        margin: 0;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    h1 {
        color: #f0f0f0;
        margin-bottom: 20px;
    }
    #cal-heatmap {
        max-width: 950px;
        padding: 20px;
        background-color: #1e1e1e;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }
    .legend {
        margin-top: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }
    .legend-item {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .legend-color {
        width: 15px;
        height: 15px;
        border-radius: 3px;
    }
    .tooltip {
        position: absolute;
        background: #2a2a2a;
        border: 1px solid #555;
        border-radius: 4px;
        padding: 5px 10px;
        font-size: 12px;
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.3s;
        color: white;
    }
</style>
</head>

    <form wire:submit="create">
<x-filament::section>
    <x-slot name="heading">
                {{ $this->form }}
    </x-slot>
            <x-filament::button type="submit"> Go </x-filament::button>

</x-filament::section>
    </form>
    <div class="legend"></div>
    <div class="tooltip" id="tooltip"></div>

    <div id="cal-heatmap" class="bg-red"></div>


</div>

@script
<script>
    let data = [];
const cal = new CalHeatmap();


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
            width: 12,
            height: 12,
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
                domain: [0, 3],
    range: ['#d4e157', '#fbc02d', '#e53935','#f44336']
            },
        },
        date: {
            start: new Date("2025-01-01"),
        },
        dynamicDimension: true,
        verticalOrientation: false,
        theme: 'light',
        ...tooltipOptions
    });
}

    window.addEventListener('heatmapDataUpdated', function (event) {
    console.log('heatmapDataUpdated event received', event.detail);

    if (event.detail && event.detail.data) {
        // Create a copy of the data to ensure we're working with fresh data
        const data = [...event.detail.data];
        console.log('Painting calendar with updated data', data);

        // Ensure we're executing this in the next tick of the event loop
        setTimeout(() => {
            paintCalendar(data);

        }, 0);
    } else {
        console.error('No data provided in the heatmapDataUpdated event');
    }
});
    window.addEventListener('refresh-page', function () {
        window.location.reload();
    });
</script>

@endscript


