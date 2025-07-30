<?php

namespace App\Livewire\Admin;

use App\Models\Badword;
use Livewire\Attributes\Title;
use App\Livewire\BaseComponent;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Illuminate\Contracts\View\View;
use App\Events\Badwords\BadwordCreated;
use App\Events\Badwords\BadwordUpdated;
use App\Events\Badwords\BadwordDeleted;
use App\Livewire\Traits\WithDataTables;
use App\Livewire\Traits\WithInlineEditing;

/**
 * Badword Management Component
 * 
 * Handles CRUD operations for managing badwords/profanity filtering system.
 * Provides bulk import functionality with predefined categories of offensive content.
 * 
 * @package App\Livewire\Admin
 */
#[Title('Badwords Management')]
#[Layout('components.layouts.admin')]
class BadwordManagement extends BaseComponent
{
    use WithDataTables, WithInlineEditing;

    // Form properties
    public int|null $id = null;
    public string $word = '';
    public string $replacement = '';
    public array $words = [];
    public bool $replace_badwords;

    // Import functionality properties
    public $selectedCategories = [];

    /**
     * Predefined categories of offensive content for bulk import
     * 
     * @var array<string, array<string>>
     */
    public array $importBadwords = [
        'profanity-mild' => [
            'damn', 'd4mn', 'darn', 'dang',
            'hell', 'h3ll', 'he11',
            'crap', 'cr4p', 'crappy',
            'piss', 'p1ss', 'pissed',
            'ass', 'a55', 'arse',
            'butt', 'bu77', 'butthole'
        ],
        
        'profanity-strong' => [
            'fuck', 'fck', 'fuk', 'f4ck', 'fuuck', 'fvck', 'phuck',
            'fucking', 'fcking', 'fuking', 'f4cking',
            'shit', 'sh1t', 'sh!t', 'sht', 'sh1tt', 'shyt', 'shiit', 'shiet',
            'bitch', 'b1tch', 'b!tch', 'bi7ch', 'bytch', 'biatch', 'beatch',
            'bastard', 'ba$tard','b4stard', 'bastrd',
            'motherfucker', 'mofo',
            'asshole', 'a55hole', 'arsehole',
        ],
        
        'sexual-explicit' => [
            'cock', 'c*ck', 'c0ck', 'cck', 'cok', 'co*k',
            'dick', 'd*ck', 'd1ck', 'di*k', 'dik', 'dck', 'd!ck',
            'penis', 'p*nis', 'pen1s', 'peni$', 'pen!s',
            'pussy', 'p*ssy', 'pu$$y', 'pu55y', 'pus*y', 'puzsy',
            'vagina', 'v*gina', 'vag1na', 'vag!na', 'vag',
            'boobs', 'b**bs', 'boobz', 'b00bs',
            'tits', 't*ts', 'ti*s', 't!ts', 'teets',
            'sex', 's*x', 's3x', 'sexx', 'secks',
            'porn', 'p*rn', 'po*n', 'pr0n', 'pron',
            'nude', 'n*de', 'nud3', 'naked', 'nak3d',
            'horny', 'h*rny', 'horn3y', 'ho*ny'
        ],
        
        'derogatory-general' => [
            'idiot', '!diot', 'id!ot', 'idi0t', 'id10t',
            'stupid', 'st*pid', 'stup1d', 'stu*id', 'stoopid',
            'moron', 'm*ron', 'mor0n', 'mo*on', 'moorn',
            'retard', 'r*tard', 'ret4rd', 'reta*d', 'ret@rd',
            'dumb', 'd*mb', 'dum*', 'du*b', 'duhm',
            'loser', 'l*ser', 'los3r', 'lose*', 'looser',
            'freak', 'fr*ak', 'fre4k', 'fr34k', 'phreak',
            'weirdo', 'w*irdo', 'we1rdo', 'weird0'
        ],
        
        'hate-speech' => [
            'nigger', 'n*gger', 'n1gger', 'nig*er', 'nigg*r', 'n!gger',
            'faggot', 'f*ggot', 'fag*ot', 'f4ggot', 'fagg0t',
            'kike', 'k*ke', 'k1ke', 'kyke',
            'spic', 'sp*c', 'sp1c', 'spik',
            'chink', 'ch*nk', 'ch1nk', 'chinq',
            'wetback', 'w*tback', 'wetb4ck',
            'cracker', 'cr*cker', 'crack3r',
            'honkey', 'h*nkey', 'honk3y', 'honky'
        ],
        
        'offensive-slurs' => [
            'whore', 'wh*re', 'who*e', 'wh0re', 'hor3',
            'slut', 'sl*t', 'slu7', 's1ut', 'sloot',
            'hoe', 'h*e', 'ho3', 'h03',
            'skank', 'sk*nk', 'sk4nk', 'skanq',
            'tramp', 'tr*mp', 'tr4mp', 'trmp',
            'thot', 'th*t', 'th0t', 'thoт'
        ],
        
        'religious-blasphemy' => [
            'goddamn', 'g*ddamn', 'godd4mn', 'god*amn', 'goddam',
            'jesus christ', 'jesus', 'j*sus', 'jes*s',
            'christ', 'ch*ist', 'chr1st', 'chri*t',
            'holy shit', 'holy', 'h*ly'
        ],
        
        'violence-threats' => [
            'kill', 'k*ll', 'ki11', 'kil*', 'kyll',
            'murder', 'm*rder', 'murd3r', 'murde*',
            'die', 'd*e', 'di3', 'dy3',
            'death', 'd*ath', 'de4th', 'dea*h',
            'stab', 'st*b', 'st4b', 'stabb',
            'shoot', 'sh*ot', 'sho0t', 'sh00t'
        ],
        
        'body-parts-vulgar' => [
            'ballsack', 'b*llsack', 'ba11sack', 'ball$ack',
            'balls', 'b*lls', 'ba11s', 'ball$',
            'nuts', 'n*ts', 'nu7s', 'nut$',
            'scrotum', 'scr*tum', 'scrot*m'
        ],
        
        'drugs-alcohol' => [
            'weed', 'w**d', 'we3d', 'w33d',
            'pot', 'p*t', 'po7', 'p0t',
            'marijuana', 'm*rijuana', 'mar1juana', 'marij*ana',
            'cocaine', 'c*caine', 'coc4ine', 'coca!ne',
            'crack', 'cr*ck', 'cr4ck', 'crak',
            'heroin', 'h*roin', 'hero1n', 'herо1n',
            'meth', 'm*th', 'me7h', 'm3th',
            'drunk', 'dr*nk', 'dru*k', 'drun*'
        ],
        
        'internet-slang' => [
            'noob', 'n**b', 'n00b', 'newb', 'nub',
            'pwned', 'pw*ed', 'pwn3d', 'owned',
            'lmao', 'lm*o', 'lma0', 'rofl',
            'wtf', 'w*f', 'wth', 'what the f*ck',
            'omfg', 'omg', 'o*g', '0mg',
            'stfu', 'st*u', 'stf*', 'shut up'
        ],
        
        'gaming-toxic' => [
            'camper', 'c*mper', 'camp3r', 'kamper',
            'hacker', 'h*cker', 'hack3r', 'hax0r',
            'cheater', 'ch*ater', 'cheat3r', 'che4ter',
            'tryhard', 'try*ard', 'tryh4rd', 'try-hard',
            'scrub', 'scr*b', 'scru*', 'skrub'
        ]
    ];

    /**
     * Component initialization
     * 
     * @return void
     */
    public function mount(): void
    {
        $this->selectedCategories = [];
    }

    /**
     * Form validation rules
     * 
     * @return array<string, array>
     */
    public function rules(): array
    {
        return [
            'word' => ['required', 'min:3', Rule::unique('badwords', 'word')->ignore($this->id)],
            'replacement' => ['nullable', 'min:3']
        ];
    }

    /**
     * Create a new badword record
     * 
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(): void
    {
        $this->authorize('create badwords');
        $this->validate();

        $badword = Badword::create([
            'word' => $this->pull('word'),
            'replacement' => $this->pull('replacement')
        ]);

        event(new BadwordCreated($badword));

        $this->showSuccessToast('Badword Added', 'Badword added successfully.');
        $this->closeModal();
    }

    /**
     * Show confirmation modal for deleting a badword
     * 
     * @param int $id
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showConfirmDeleteForm(int $id): void
    {
        $this->authorize('delete badwords');

        $badword = Badword::findOrFail($id);
        $this->id = $badword->id;

        $this->showModal('delete-badword-form');
    }

    /**
     * Delete a badword record
     * 
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(): void
    {
        $this->authorize('delete badwords');

        $badword = Badword::findOrFail($this->id);
        
        event(new BadwordDeleted($badword));
        $badword->delete();

        $this->showDangerToast('Badword Deleted', 'Badword deleted successfully.');
        $this->closeModal();
    }

    /**
     * Bulk delete selected badwords
     * 
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function deleteSelected(): void
    {
        $this->authorize('delete badwords');

        if (empty($this->selectedItems)) {
            $this->showErrorToast('Error', 'No badwords selected.');
            return;
        }

        $deletedCount = Badword::whereIn('id', $this->selectedItems)->count();
        Badword::whereIn('id', $this->selectedItems)->delete();

        $this->showSuccessToast('Success!', "{$deletedCount} badword(s) deleted successfully.");
    }

    /**
     * Import all words from selected categories into database
     * 
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function import(): void
    {
        $this->authorize('create badwords');

        $this->validate(['selectedCategories' => 'required|array|min:1']);

        // Get all words from selected categories
        $wordsToImport = [];
        foreach ($this->selectedCategories as $category) {
            if (isset($this->importBadwords[$category])) {
                $wordsToImport = array_merge($wordsToImport, $this->importBadwords[$category]);
            }
        }

        if (empty($wordsToImport)) {
            $this->showErrorToast('Error', 'No words found in selected categories.');
            return;
        }

        // Remove duplicates
        $wordsToImport = array_unique($wordsToImport);

        // Import words
        [$importedCount, $skippedCount] = $this->processWordImport($wordsToImport);

        $message = $this->buildImportSuccessMessage($importedCount, $skippedCount);
        $this->showSuccessToast('Import Complete', $message);

        $this->reset('selectedCategories');
        $this->closeModal('import-form');
    }

    /**
     * Get available import categories
     * 
     * @return array<string>
     */
    #[Computed]
    public function importCategories(): array
    {
        return array_keys($this->importBadwords);
    }

    /**
     * Get paginated badword results with search and sort applied, cached
     * 
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    #[Computed]
    public function badwords(): \Illuminate\Pagination\LengthAwarePaginator
    {
        $query = Badword::query();

        $this->applySorting($query);
        $this->applySearch($query, ['word', 'replacement']);

        return $query->paginate($this->perPage);
    }

    /**
     * Hook called after inline update
     * 
     * @param mixed $model
     * @return void
     */
    protected function afterInlineUpdate($model): void
    {
        if ($model instanceof Badword) {
            event(new BadwordUpdated($model));
        }
    }

    /**
     * Render the component view
     * 
     * @return View
     */
    public function render(): View
    {
        return view('livewire.admin.badword-management');
    }

    // Private helper methods

    /**
     * Process the import of words
     * 
     * @param array $words
     * @return array{int, int} [importedCount, skippedCount]
     */
    private function processWordImport(array $words): array
    {
        $importedCount = 0;
        $skippedCount = 0;

        foreach ($words as $word) {
            if (Badword::where('word', $word)->exists()) {
                $skippedCount++;
                continue;
            }

            $badword = Badword::create([
                'word' => $word,
                'replacement' => ''
            ]);

            event(new BadwordCreated($badword));
            $importedCount++;
        }

        return [$importedCount, $skippedCount];
    }

    /**
     * Build import success message
     * 
     * @param int $importedCount
     * @param int $skippedCount
     * @return string
     */
    private function buildImportSuccessMessage(int $importedCount, int $skippedCount): string
    {
        $message = "Imported {$importedCount} badword(s)";
        
        if ($skippedCount > 0) {
            $message .= " ({$skippedCount} skipped - already exist)";
        }

        return $message;
    }

    /**
     * Show success toast notification
     * 
     * @param string $heading
     * @param string $text
     * @return void
     */
    private function showSuccessToast(string $heading, string $text): void
    {
        $this->toast([
            'heading' => $heading,
            'text' => $text,
            'variant' => 'success'
        ]);
    }

    /**
     * Show error toast notification
     * 
     * @param string $heading
     * @param string $text
     * @return void
     */
    private function showErrorToast(string $heading, string $text): void
    {
        $this->toast([
            'heading' => $heading,
            'text' => $text,
            'variant' => 'danger'
        ]);
    }

    /**
     * Show danger toast notification
     * 
     * @param string $heading
     * @param string $text
     * @return void
     */
    private function showDangerToast(string $heading, string $text): void
    {
        $this->toast([
            'heading' => $heading,
            'text' => $text,
            'variant' => 'danger'
        ]);
    }
}