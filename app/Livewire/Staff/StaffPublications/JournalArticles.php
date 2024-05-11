<?php

namespace App\Livewire\Staff\StaffPublications;

use App\Models\StaffPublication;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class JournalArticles extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public $title, $authors, $year, $journal, $journal_volume, $doi, $details, $abstract, $evidence, $category_id;
    public $user, $staffId, $deleteName;
    public $search;
    public $publication_id;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function rules(){
        return [
            'title' => 'required|string',
            'authors' => 'required|string',
            'year' => 'required|numeric',
            'journal' => 'required|string',
            'journal_volume' => 'required|string',
            'doi' => 'nullable|string',
            'details' => 'nullable|string|max:1000',
            'abstract' => 'nullable|mimes:pdf|max:5120',
            'evidence' => 'nullable|mimes:pdf|max:5120',
        ];
    }

    public function resetInput(){
        $this->title = null;
        $this->authors = null;
        $this->year = null;
        $this->journal = null;
        $this->journal_volume = null;
        $this->doi = null;
        $this->details = null;
        $this->abstract = null;
        $this->evidence = null;
        $this->category_id = null;
    }

    public function closeModal() {
        $this->resetInput();
    }
    public function openModal() {
        $this->resetInput();
    }

    public function storePublication(){

        $validatedData = $this->validate();

        $staffId = auth()->user()->staffId;
        $currentTimestamp = now()->timestamp;

        $abstractfile = null;
        $evidencefile = null;

        if ($this->abstract) {
            $abstractfile = $staffId . '_' . $currentTimestamp . '.' . $this->abstract->getClientOriginalExtension();
            File::move($this->abstract->getRealPath(), public_path('uploads/documents/' . $abstractfile));
        }

        if ($this->evidence) {
            $evidencefile = $staffId . '_' . $currentTimestamp . '.' . $this->evidence->getClientOriginalExtension();
            File::move($this->evidence->getRealPath(), public_path('uploads/documents/' . $evidencefile));
        }


        $this->user->staffPublications()->create([
            'title' => $validatedData['title'],
            'authors' => $validatedData['authors'],
            'year' => $validatedData['year'],
            'journal' => $validatedData['journal'],
            'journal_volume' => $validatedData['journal_volume'],
            'doi' => $validatedData['doi'],
            'details' => $validatedData['details'],
            'abstract' => $abstractfile,
            'abstractFileName' => $this->abstract ? $this->abstract->getClientOriginalName() : null,
            'evidence' => $evidencefile,
            'evidenceFileName' => $this->evidence ? $this->evidence->getClientOriginalName() : null,
            'category_id' => 2,
        ]);


        session()->flash('message', 'Publication Added Successfully.');

        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function editPublication(int $publication_id){
        $this->publication_id = $publication_id;
        $publication = StaffPublication::findOrFail($publication_id);
        $this->title = $publication->title;
        $this->authors = $publication->authors;
        $this->year = $publication->year;
        $this->journal = $publication->journal;
        $this->journal_volume = $publication->journal_volume;
        $this->doi = $publication->doi;
        $this->details = $publication->details;
    }

    public function updatePublication(){

        $rules = [
            'title' => 'required|string',
            'authors' => 'required|string',
            'year' => 'required|numeric',
            'journal' => 'required|string',
            'journal_volume' => 'required|string',
            'doi' => 'nullable|string',
            'details' => 'nullable|string',
        ];

        $validatedData = $this->validate($rules);

        $publication = StaffPublication::findOrFail($this->publication_id);

        $publication->title = $validatedData['title'];
        $publication->authors = $validatedData['authors'];
        $publication->year = $validatedData['year'];
        $publication->journal = $validatedData['journal'];
        $publication->journal_volume = $validatedData['journal_volume'];

        $publication->save();

        session()->flash('message', 'Publication Updated Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function changeAbstract() {

        $rules = [
            'abstract' => 'required|mimes:pdf|max:5120',
        ];

        $validatedData = $this->validate($rules);

        $publication = StaffPublication::findOrFail($this->publication_id);

        $staffId = auth()->user()->staffId;
        $currentTimestamp = now()->timestamp;

        // Delete existing abstract file
        $existingAbstract = $publication->abstract;
        if ($existingAbstract && file_exists('uploads/documents/' . $existingAbstract)) {
            unlink('uploads/documents/' . $existingAbstract);
        }

        // Generate new abstract file name
        $abstractfile = $staffId . '_' . $currentTimestamp . '.' . $validatedData['abstract']->getClientOriginalExtension();
        $publication->abstract = $abstractfile;
        $publication->abstractFileName = $validatedData['abstract']->getClientOriginalName();
        // Move new abstract file
        File::move($this->abstract->getRealPath(), public_path('uploads/documents/' . $abstractfile));

        $publication->abstract = $abstractfile;
        $publication->abstractFileName = $validatedData['abstract']->getClientOriginalName();

        $publication->save();

        session()->flash('message', 'Abstract Updated Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function changeEvidence() {

        $rules = [
            'evidence' => 'required|mimes:pdf|max:5120',
        ];

        $validatedData = $this->validate($rules);

        $publication = StaffPublication::findOrFail($this->publication_id);

        $staffId = auth()->user()->staffId;
        $currentTimestamp = now()->timestamp;

        // Delete existing evidence file
        $existingEvidence = $publication->evidence;
        if ($existingEvidence && file_exists('uploads/documents/' . $existingEvidence)) {
            unlink('uploads/documents/' . $existingEvidence);
        }

        // Generate new abstract file name
        $evidencefile = $staffId . '_' . $currentTimestamp . '.' . $validatedData['evidence']->getClientOriginalExtension();
        $publication->evidence = $evidencefile;
        $publication->evidenceFileName = $validatedData['evidence']->getClientOriginalName();
        // Move new abstract file
        File::move($this->evidence->getRealPath(), public_path('uploads/documents/' . $evidencefile));

        $publication->evidence = $evidencefile;
        $publication->evidenceFileName = $validatedData['evidence']->getClientOriginalName();

        $publication->save();

        session()->flash('message', 'Evidence Updated Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }
    public function deletePublication($publication_id)
    {
        $this->publication_id = $publication_id;
        $publication = StaffPublication::findOrFail($publication_id);
    }

    public function destroyPublication()
    {
        try {
            $publication = StaffPublication::FindOrFail($this->publication_id);
            $existingAbstract = $publication->abstract;
            $existingEvidence = $publication->evidence;
            $publication->delete();

            // Delete documents
            if ($existingAbstract && file_exists('uploads/documnets/' . $existingAbstract)) {
                unlink('uploads/documnets/' . $existingAbstract);
            }

            if ($existingEvidence && file_exists('uploads/documnets/' . $existingEvidence)) {
                unlink('uploads/documnets/' . $existingEvidence);
            }

            session()->flash('message', 'Publication deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1451) { // check if error is foreign key constraint violation
                session()->flash('error', 'Cannot delete publication because it is referenced in user profile.');
            } else {
                session()->flash('error', 'An error occurred while deleting the publication.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the publication.');
        }

        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function downloadAbstract($filename)
    {
        $file = public_path('uploads/documents/' . $filename);

        return Response::download($file);
    }

    public function downloadEvidence($filename)
    {
        $file = public_path('uploads/documents/' . $filename);

        return Response::download($file);
    }

    public function render()
    {
        $publications = StaffPublication::where('user_id', $this->user->id)
            ->where('category_id', 2)
            ->where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('authors', 'like', '%' . $this->search . '%')
                    ->orWhere('year', 'like', '%' . $this->search . '%')
                    ->orWhere('doi', 'like', '%' . $this->search . '%')
                    ->orWhere('journal', 'like', '%' . $this->search . '%');
            })
            ->orderBy('year', 'desc')
            ->paginate(5);

        return view('livewire.staff.staff-publications.articles', [
            'publications' => $publications,
            ])->extends('layouts.staff')->section('content');
    }

}
