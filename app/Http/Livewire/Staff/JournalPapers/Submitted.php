<?php

namespace App\Http\Livewire\Staff\JournalPapers;

use Livewire\Component;
use App\Models\JournalPaper;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class Submitted extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public $title, $authors, $year, $journal, $journal_volume, $abstract, $evidence, $isSubmitted;
    public $user, $staffId, $deleteName;
    public $search;

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
            'abstract' => 'required|mimes:pdf|max:5120',
            'evidence' => 'required|mimes:pdf|max:5120',
        ];
    }

    public function resetInput(){
        $this->title = null;
        $this->authors = null;
        $this->year = null;
        $this->journal = null;
        $this->journal_volume = null;
        $this->abstract = null;
        $this->evidence = null;
    }

    public function closeModal() {
        $this->resetInput();
    }
    public function openModal() {
        $this->resetInput();
    }

    public function storePaper(){

        $validatedData = $this->validate();

        $staffId = auth()->user()->staffId;
        $currentTimestamp = now()->timestamp;

        $abstractfile = $staffId . '_' . $currentTimestamp . '.' . $validatedData['abstract']->getClientOriginalExtension();
        $evidencefile = $staffId . '_' . $currentTimestamp . '.' . $validatedData['evidence']->getClientOriginalExtension();

        $this->user->journalPapers()->create([
            'title' => $validatedData['title'],
            'authors' => $validatedData['authors'],
            'year' => $validatedData['year'],
            'journal' => $validatedData['journal'],
            'journal_volume' => $validatedData['journal_volume'],
            'abstract' => $abstractfile,
            'abstractFileName' =>$validatedData['abstract']->getClientOriginalName(),
            'evidence' => $evidencefile,
            'evidenceFileName' => $validatedData['evidence']->getClientOriginalName(),
            'isSubmitted' => 1,
        ]);

        File::move($this->abstract->getRealPath(), public_path('uploads/documents/' . $abstractfile));
        File::move($this->evidence->getRealPath(), public_path('uploads/documents/' . $evidencefile));

        session()->flash('message', 'Submitted Journal Paper Added Successfully.');

        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function editPaper(int $paper_id){
        $this->paper_id = $paper_id;
        $paper = JournalPaper::findOrFail($paper_id);
        $this->title = $paper->title;
        $this->authors = $paper->authors;
        $this->year = $paper->year;
        $this->journal = $paper->journal;
        $this->journal_volume = $paper->journal_volume;
        $this->abstract = $paper->abstract;
        $this->abstractFileName = $paper->abstractFileName;
        $this->evidence = $paper->evidence;
        $this->evidenceFileName = $paper->evidenceFileName;
    }

    public function updatePaper(){

        $rules = [
            'title' => 'required|string',
            'authors' => 'required|string',
            'year' => 'required|numeric',
            'journal' => 'required|string',
            'journal_volume' => 'required|string',
        ];

        $validatedData = $this->validate($rules);

        $paper = JournalPaper::findOrFail($this->paper_id);

        $paper->title = $validatedData['title'];
        $paper->authors = $validatedData['authors'];
        $paper->year = $validatedData['year'];
        $paper->journal = $validatedData['journal'];
        $paper->journal_volume = $validatedData['journal_volume'];

        $paper->save();

        session()->flash('message', 'Submitted Journal Paper Updated Successfully.');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function changeAbstract() {

        $rules = [
            'abstract' => 'required|mimes:pdf|max:5120',
        ];

        $validatedData = $this->validate($rules);

        $paper = JournalPaper::findOrFail($this->paper_id);

        $staffId = auth()->user()->staffId;
        $currentTimestamp = now()->timestamp;

        // Delete existing abstract file
        $existingAbstract = $paper->abstract;
        if ($existingAbstract && file_exists('uploads/documents/' . $existingAbstract)) {
            unlink('uploads/documents/' . $existingAbstract);
        }

        // Generate new abstract file name
        $abstractfile = $staffId . '_' . $currentTimestamp . '.' . $validatedData['abstract']->getClientOriginalExtension();
        $paper->abstract = $abstractfile;
        $paper->abstractFileName = $validatedData['abstract']->getClientOriginalName();
        // Move new abstract file
        File::move($this->abstract->getRealPath(), public_path('uploads/documents/' . $abstractfile));

        $paper->abstract = $abstractfile;
        $paper->abstractFileName = $validatedData['abstract']->getClientOriginalName();

        $paper->save();

        session()->flash('message', 'Abstract Updated Successfully.');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function changeEvidence() {

        $rules = [
            'evidence' => 'required|mimes:pdf|max:5120',
        ];

        $validatedData = $this->validate($rules);

        $paper = JournalPaper::findOrFail($this->paper_id);

        $staffId = auth()->user()->staffId;
        $currentTimestamp = now()->timestamp;

        // Delete existing evidence file
        $existingEvidence = $paper->evidence;
        if ($existingEvidence && file_exists('uploads/documents/' . $existingEvidence)) {
            unlink('uploads/documents/' . $existingEvidence);
        }

        // Generate new abstract file name
        $evidencefile = $staffId . '_' . $currentTimestamp . '.' . $validatedData['evidence']->getClientOriginalExtension();
        $paper->evidence = $evidencefile;
        $paper->evidenceFileName = $validatedData['evidence']->getClientOriginalName();
        // Move new abstract file
        File::move($this->evidence->getRealPath(), public_path('uploads/documents/' . $evidencefile));

        $paper->evidence = $evidencefile;
        $paper->evidenceFileName = $validatedData['evidence']->getClientOriginalName();

        $paper->save();

        session()->flash('message', 'Evidence Updated Successfully.');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }
    public function deletePaper($paper_id)
    {
        $this->paper_id = $paper_id;
        $paper = JournalPaper::findOrFail($paper_id);
    }

    public function destroyPaper()
    {
        try {
            $paper = JournalPaper::FindOrFail($this->paper_id);
            $existingAbstract = $paper->abstract;
            $existingEvidence = $paper->evidence;
            $paper->delete();

            // Delete documents
            if ($existingAbstract && file_exists('uploads/documnets/' . $existingAbstract)) {
                unlink('uploads/documnets/' . $existingAbstract);
            }

            if ($existingEvidence && file_exists('uploads/documnets/' . $existingEvidence)) {
                unlink('uploads/documnets/' . $existingEvidence);
            }

            session()->flash('message', 'Submitted Journal Paper deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1451) { // check if error is foreign key constraint violation
                session()->flash('error', 'Cannot delete journal paper because it is referenced in user profile.');
            } else {
                session()->flash('error', 'An error occurred while deleting the journal paper.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the journal paper.');
        }

        $this->dispatchBrowserEvent('close-modal');
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

    public function viewAbstract($filename)
    {
        return redirect()->to('/uploads/documents/' . $filename);
    }

    public function viewEvidence($filename)
    {
        return redirect()->to('/uploads/documents/' . $filename);
    }

    public function render()
    {
        $papers = JournalPaper::where('user_id', $this->user->id)
            ->where('isSubmitted', 1)
            ->where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('authors', 'like', '%' . $this->search . '%')
                    ->orWhere('year', 'like', '%' . $this->search . '%')
                    ->orWhere('journal', 'like', '%' . $this->search . '%');
            })
            ->orderBy('year', 'desc')
            ->paginate(5);

        return view('livewire.staff.journal-papers.submitted', [
            'papers' => $papers,
            ])->extends('layouts.staff')->section('content');
    }
}
