<?php

namespace App\Policies;

use App\Models\PortfolioItem;
use App\Models\User;

class PortfolioItemPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'creator' && $user->creatorProfile !== null;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PortfolioItem $portfolioItem): bool
    {
        return $user->role === 'creator' && 
               $user->creatorProfile && 
               $user->creatorProfile->id === $portfolioItem->creator_profile_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'creator' && $user->creatorProfile !== null;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PortfolioItem $portfolioItem): bool
    {
        return $user->role === 'creator' && 
               $user->creatorProfile && 
               $user->creatorProfile->id === $portfolioItem->creator_profile_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PortfolioItem $portfolioItem): bool
    {
        return $user->role === 'creator' && 
               $user->creatorProfile && 
               $user->creatorProfile->id === $portfolioItem->creator_profile_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PortfolioItem $portfolioItem): bool
    {
        return $this->delete($user, $portfolioItem);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PortfolioItem $portfolioItem): bool
    {
        return $this->delete($user, $portfolioItem);
    }
}