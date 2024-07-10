<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class StoresChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($unactive, $active): \ArielMejiaDev\LarapexCharts\PieChart
    {
        return $this->chart->pieChart()
            ->setTitle('Stores in System')
            ->setSubtitle('Season 2021.')
            ->addData([$active, $unactive, 0])
            ->setLabels(['Active Stores', ' Un Active', 'Pending']);
    }
}
