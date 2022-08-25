<?php

namespace Advans\Api\Pdf;

class MetricsSummary {
    public
        $requests_1h,
        $requests_24h,
        $requests_30d,
        $avg_processing_time_1h,
        $avg_response_time_1h,
        $cached_rate_1h,
        $input_size_30d,
        $output_size_30d,
        $requests_by_ip_30d,
        $requests_by_day_30d;

    public function __construct($args) {
        $this->requests_1h = $args['requests_1h'] ?? null;
        $this->requests_24h = $args['requests_24h'] ?? null;
        $this->requests_30d = $args['requests_30d'] ?? null;
        $this->avg_processing_time_1h = $args['avg_processing_time_1h'] ?? null;
        $this->avg_response_time_1h = $args['avg_response_time_1h'] ?? null;
        $this->cached_rate_1h = $args['cached_rate_1h'] ?? null;
        $this->input_size_30d = $args['input_size_30d'] ?? null;
        $this->output_size_30d = $args['output_size_30d'] ?? null;
        $this->requests_by_ip_30d = $args['requests_by_ip_30d'] ?? null;
        $this->requests_by_day_30d = $args['requests_by_day_30d'] ?? null;
    }
}