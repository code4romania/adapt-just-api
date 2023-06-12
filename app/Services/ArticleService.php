<?php

namespace App\Services;

use App\Constants\ArticleConstant;
use App\Models\Article;
use App\Models\Filters\DateBetweenFilter;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ArticleService
{
    public static function articles($perPage = 10): LengthAwarePaginator
    {
        return QueryBuilder::for(Article::class)
            ->allowedSorts(['id', 'name', 'status', 'published_at'])
            ->allowedFilters([
                'name', 'status',
                AllowedFilter::custom('published_at', new DateBetweenFilter),

            ])
            ->paginate($perPage);
    }

    public static function create($data): Model|Builder
    {
        $data['published_at'] = Arr::get($data,'status') == ArticleConstant::STATUS_DRAFT ? null : Carbon::now();
        return Article::create($data);
    }

    public static function update($data, $id): Model|Builder
    {
        $data['published_at'] = Arr::get($data,'status') == ArticleConstant::STATUS_DRAFT ? null : Carbon::now();
        $article = Article::find($id);
        $article->update($data);

        return $article;
    }


    public static function delete(Article $article): ?bool
    {
        return $article->delete();
    }

}
