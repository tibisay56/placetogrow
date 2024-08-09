<?php

namespace App\Services;

use App\Models\Site;
use App\Models\Type;
use Illuminate\Pagination\LengthAwarePaginator;
use Ramsey\Collection\Collection;

class WelcomeService
{
    public function getTypes(): Collection
    {
        return Type::query()
            -> select('id', 'name')
            -> with ('media')
            -> get()
            -> map(function ($type){
                return[
                    'id' => $type->id,
                    'name' => $type->name,
                    'logo' => asset('images/types/type_'. random_int(1, 5).'svg'),
                ];
            });
    }
    public function filterSites(?string $typeFilter, ?string $searchFilter): LengthAwarePaginator
    {
        $sitesQuery = Site::query()
            ->select('id', 'name', 'slug', 'type_id')
            ->when($typeFilter, function ($query) use ($typeFilter) {
                return $query->where('type_id', $typeFilter);
            })
            ->when($searchFilter, function ($query) use ($searchFilter) {
                return $query->where('name', 'like', '%' . $searchFilter . '%');
            });

        $sites = $sitesQuery->paginate(10)->withQueryString();

        $sites->getCollection()->transform(function ($site) {
            return [
                'id' => $site->id,
                'name' => $site->name,
                'slug' => $site->slug,
                'logo' => asset('storage/' . $site->logo),
            ];
        });
        return $sites;
    }

    public function filterSiteWithType(?string $typeFilter, ?string $searchFilter)
    {
        $sitesQuery = Site::query()
            ->select('site.id', 'sites.name as site_name', 'sites.slug', 'sites.type_id', 'types.name as type_name')
            ->leftJoin('types', 'sites.type_id', '=', 'types.id')
            ->when($typeFilter, function ($query, $typeFilter) {
                return $query->where('sites.type_id', $typeFilter);
            })
            ->when($searchFilter, function ($query, $searchFilter) {
                return $query->where('sites.name', 'like', '%' . $searchFilter . '%');
            });

        $sites = $sitesQuery->paginate(10)->withQueryString();

        $sites->getCollection()->transform(function ($site) {
            return [
                'id' => $site->id,
                'name' => $site->name,
                'slug' => $site->slug,
                'type' => [
                    'id' => $site->type->id,
                    'name' => $site->type->name,
                    'logo' => asset('storage/'. $site->logo),
                ],
                'logo' => asset('storage/' . $site->logo),
            ];
        });
        return $sites;
    }
}

