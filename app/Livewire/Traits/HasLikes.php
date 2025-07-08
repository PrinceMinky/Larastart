<?php

namespace App\Livewire\Traits;

use App\Models\User;
use App\Livewire\Traits\HasFollowers;
use App\Services\LikeService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Livewire\Traits\WithModal;

/**
 * Trait HasLikes
 * 
 * Provides like/unlike functionality and UI modal management for models.
 * Components using this trait must define the `likeModelClass` property specifying the model class being liked.
 * 
 * Requires Livewire lifecycle method `initializeHasLikes` to automatically assign the authenticated user.
 * 
 * @property string $likeModelClass  The model class this trait operates on (e.g. Post::class, Comment::class).
 * @property string $likesSearch     Search string to filter liked users.
 * @property array  $likedModelIds   Cache of model IDs liked by the current user.
 * @property Collection|null $likedByUsers Collection of users who liked the current model being viewed.
 * @property User   $user           Currently authenticated user (automatically set in initializeHasLikes).
 */
trait HasLikes
{
    use WithModal, HasFollowers;

    /** @var string Search input for filtering liked users in modal */
    public string $likesSearch = '';

    /** @var array IDs of models liked by the current user */
    public array $likedModelIds = [];

    /** @var Collection|null Cached collection of users who liked the currently selected model */
    public ?Collection $likedByUsers = null;

    /** @var User The currently authenticated user */
    public User $user;

    /**
     * Livewire lifecycle hook called automatically on component boot.
     * Assigns the authenticated user to the $user property for use within the component.
     */
    public function initializeHasLikes(): void
    {
        $this->user = Auth::user();
    }

    /**
     * Toggle like/unlike state on a model by ID.
     * Uses the LikeService to perform the action.
     * Updates the likedModelIds cache after toggling.
     * 
     * @param int $id The ID of the model to like/unlike.
     * @param string $relation The relationship name on the model representing likes. Defaults to 'likedByUsers'.
     * 
     * @return void
     */
    public function like(int $id, string $relation = 'likedByUsers'): void
    {
        $model = $this->resolveLikeModel($id, $relation);

        $this->likeService()->toggle($model, Auth::id(), $relation);

        // Refresh the cached liked IDs for the current user
        $this->likedModelIds = $this->likeService()->getUserLikedIds($this->likeModelClass, Auth::id(), $relation);
    }

    /**
     * Display a modal showing the users who liked a specific model.
     * Loads liked users into $likedByUsers and resets search.
     * 
     * @param int $id The model ID to fetch liked users for.
     * @param string $relation The relationship name representing likes.
     * @param string|null $modalName Optional modal name to show; defaults to 'show-likes-modal'.
     * 
     * @return void
     */
    public function showLikes(int $id, string $relation = 'likedByUsers', ?string $modalName = null): void
    {
        $model = $this->resolveLikeModel($id, $relation);

        $this->likesSearch = '';
        $this->likedByUsers = $model->{$relation} ?? collect();

        $this->showModal($modalName ?? 'show-likes-modal');
    }

    /**
     * Check if the currently authenticated user has liked a given model.
     * 
     * @param Model $model The model to check for like status.
     * @param string $relation The like relation name.
     * @return bool True if current user liked the model, false otherwise.
     */
    public function isLikedByCurrentUser(Model $model, string $relation = 'likedByUsers'): bool
    {
        return $this->likeService()->hasUserLiked($model, Auth::id(), $relation);
    }

    /**
     * Return a string label for the number of likes.
     * Customize to add suffix or special text if needed.
     * 
     * @param Model $model The model instance.
     * @param int $totalLikes Number of likes.
     * @param string $relation The like relation name.
     * 
     * @return string Number of likes as string or empty if none.
     */
    public function getLikeText(Model $model, int $totalLikes, string $relation = 'likedByUsers'): string
    {
        return $totalLikes > 0 ? (string) $totalLikes : '';
    }

    /**
     * Filter the list of liked users based on the $likesSearch input.
     * Case-insensitive search on user's name or username.
     * 
     * @return Collection Filtered collection of User models.
     */
    public function getFilteredLikedUsers(): Collection
    {
        if (is_null($this->likedByUsers)) {
            return collect();
        }

        $search = trim(strtolower($this->likesSearch));

        if ($search === '') {
            return $this->likedByUsers;
        }

        return $this->likedByUsers->filter(fn (User $user) =>
            str_contains(strtolower($user->name ?? ''), $search) ||
            str_contains(strtolower($user->username ?? ''), $search)
        );
    }

    /**
     * Retrieve the likeable model instance by ID, eager loading roles on the like relation.
     * Throws if $likeModelClass is not defined.
     * 
     * @param int $id Model ID.
     * @param string $relation Like relation name.
     * @return Model The loaded model instance.
     */
    protected function resolveLikeModel(int $id, string $relation = 'likedByUsers'): Model
    {
        if (empty($this->likeModelClass)) {
            throw new \RuntimeException("Property 'likeModelClass' must be set in the component using HasLikes.");
        }

        return App::make($this->likeModelClass)
            ->with("$relation.roles") // eager load roles relationship on liked users, if exists
            ->findOrFail($id);
    }

    /**
     * Get the LikeService instance.
     * 
     * @return LikeService
     */
    protected function likeService(): LikeService
    {
        return app(LikeService::class);
    }

    /**
     * Get the like model class name.
     * Throws if not set.
     * 
     * @return string
     */
    protected function getLikeModelClass(): string
    {
        if (empty($this->likeModelClass)) {
            throw new \RuntimeException("Property 'likeModelClass' must be set in the component using HasLikes.");
        }

        return $this->likeModelClass;
    }
}