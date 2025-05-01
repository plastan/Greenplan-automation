<x-filament-panels::page>
    <x-filament::section>
        <div class="activity-calendar-container">
            <h1 class="text-2xl font-bold mb-4">{{ $title ?? '2025 Activity Calendar' }}</h1>
            <div id="activity-calendar"></div>
            <div class="legend mt-4"></div>
            <div class="tooltip" id="tooltip"></div>
    <button wire:click="update">Generate Data</button>
        </div>

        <script src="https://d3js.org/d3.v7.min.js"></script>
        <script src="https://unpkg.com/cal-heatmap/dist/cal-heatmap.min.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/cal-heatmap/dist/cal-heatmap.css">

        <style>
            .activity-calendar-container {
                display: flex;
                flex-direction: column;
                align-items: center;
                width: 100%;
            }
            #activity-calendar {
                max-width: 950px;
                width: 100%;
                padding: 20px;
                background-color: var(--gray-800);
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            }
            .legend {
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 10px;
                margin-top: 1rem;
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
                background: var(--gray-700);
                border: 1px solid var(--gray-600);
                border-radius: 4px;
                padding: 5px 10px;
                font-size: 12px;
                pointer-events: none;
                opacity: 0;
                transition: opacity 0.3s;
                color: white;
                z-index: 9999;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize calendar
                const cal = new CalHeatmap();

                // Get data from PHP
                const calendarData = @json($this->getActivityData());

                // Custom tooltip handler
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

                // Paint the calendar
                cal.paint({
                    itemSelector: "#activity-calendar",
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
                        source: calendarData,
                        type: 'json',
                        x: 'date',
                        y: 'value'
                    },
                    scale: {
                        color: {
                            scheme: 'Turbo',
                            type: 'sequential',
                            domain: [0, 50],
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

                // Create the legend
                createLegend();

                function createLegend() {
                    const legend = document.querySelector('.legend');
                    legend.innerHTML = ''; // Clear any existing legend

                    const values = [0, 12.5, 25, 37.5, 50];

                    values.forEach((value) => {
                        const item = document.createElement('div');
                        item.className = 'legend-item';

                        const color = document.createElement('div');
                        color.className = 'legend-color';
                        color.style.backgroundColor = d3.interpolateTurbo(value/50);

                        const label = document.createElement('span');
                        label.textContent = Math.round(value);

                        item.appendChild(color);
                        item.appendChild(label);
                        legend.appendChild(item);
                    });
                }

            });
            }
        </script>
    </x-filament::section>
</x-filament-panels::page>
