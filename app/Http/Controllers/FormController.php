<?php

namespace App\Http\Controllers;

use App\Constants\FieldType;
use App\Http\Requests\Form\StoreFormRequest;
use App\Models\Form;
use App\Models\FormField;
use App\Models\Site;
use App\Models\Type;
use App\Strategies\FormContext;
use App\Strategies\FormStrategy;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class FormController
{
    public function index(): \Inertia\Response
    {
        $forms = Form::all();

        return Inertia::render('Form/Index', [
            'forms' => $forms,
        ]);
    }

    public function create(): \Inertia\Response
    {
        $sites = Site::with('type')->get();
        $types = Type::distinct()->get();
        $fieldTypes = FieldType::toOptions();

        return Inertia::render('Form/Create', [
            'sites' => $sites,
            'types' => $types,
            'fieldTypes' => $fieldTypes,
        ]);
    }

    public function store(StoreFormRequest $request): RedirectResponse
    {
        $form = new Form();
        $form->name = $request->input('name');
        $form -> site()->associate($request->site_id);

        $fields = $request->input('fields');
        foreach ($fields as $field) {
            FormField::create([
                'label' => $field['label'],
                'field_type' => $field['input_type'],
                'form_id' => $form->id,
            ]);
        }

        return redirect()->route('forms.index')->with('success', 'Form created successfully!');
    }

        public function edit($type)
    {

        switch ($type) {
            case 'donation':
                return view('forms.donation_form');

            case 'subscription':
                return view('forms.subscription_form');

            case 'invoice':
                return view('forms.invoice_form');

            default:
                abort(404, "Form type not found");
        }
    }

    public function submit(Request $request)
    {
        $type = $request->input('form_type');

        $strategy = $this->getStrategy($type);

        $context = new FormContext($strategy);
        $context->executeStrategy($request);

        return redirect()->back()->with('success', 'Form submitted successfully!');
    }

    private function getStrategy(string $type): FormStrategy
    {
        switch ($type) {
            case 'donation':
                return new DonationFormStrategy();

            case 'subscription':
                return new SubscriptionFormStrategy();

            case 'invoice':
                return new InvoiceFormStrategy();

            default:
                throw new \InvalidArgumentException("Invalid form type");
        }
    }
}
