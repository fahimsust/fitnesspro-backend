<?php

namespace Support\QueryBuilders;

use Support\Requests\AbstractFormRequest;

class SearchQuery
{
    public $query;

    protected AbstractFormRequest $request;

    /**
     * @var int|mixed
     */
    protected $limit;

    public function __construct($startingQuery, AbstractFormRequest $request)
    {
        $this->query = $startingQuery;
        $this->request = $request;

        $this->limit = $request->limit ?? 25;
    }

    public function startRange($requestField, $databaseField)
    {
        return $this->buildDateQuery($requestField, $databaseField);
    }

    public function endRange($requestField, $databaseField)
    {
        return $this->buildDateQuery($requestField, $databaseField);
    }

    public function where($requestField, $compare, $value = null, $databaseField = null)
    {
        if (is_null($this->request->{$requestField})) {
            return $this;
        }

        $this->query->where($databaseField ?? $requestField, $this->normalizeCompare($compare), $value ?? $this->requestValue($requestField, $compare));

        return $this;
    }

    public function paginate()
    {
        return $this->query->paginate(
            $this->limit,
            null,
            null,
            $this->request->page
        );
    }

    private function normalizeCompare($compare)
    {
        if (in_array($compare, ['like%', '%like', '%like%'])) {
            return 'like';
        }

        return $compare;
    }

    private function requestValue($field, $compare)
    {
        $value = $this->request->{$field};

        switch ($compare) {
            case '%like%':
                return "%{$value}%";

            case 'like%':
                return "{$value}%";

            case '%like':
                return "%{$value}";
        }

        return $value;
    }

    /**
     * @param $requestField
     * @param $databaseField
     * @return $this
     */
    protected function buildDateQuery($requestField, $databaseField): SearchQuery
    {
        $startDate = $this->request->{$requestField};

        if (!$startDate)
            return $this;

        $startRange = $startDate['start'] ?? null;
        if ($startRange) {
            $this->query->where($databaseField, '>=', $startRange);
        }

        $endRange = $startDate['end'] ?? null;
        if ($endRange) {
            $this->query->where($databaseField, '<=', $endRange);
        }

        return $this;
    }
}
