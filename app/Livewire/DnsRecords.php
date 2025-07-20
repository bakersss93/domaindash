<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Domain;
use App\Models\DnsRecord;
use App\Services\SynergyClient;
use Illuminate\Support\Facades\Auth;

class DnsRecords extends Component
{
    public Domain $domain;
    public $recordId = null;
    public $type = '';
    public $name = '';
    public $value = '';
    public $ttl = 3600;

    protected function rules()
    {
        return [
            'type' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'value' => 'required|string',
            'ttl' => 'required|integer',
        ];
    }

    public function mount(Domain $domain)
    {
        $this->domain = $domain;
    }

    protected function authorizeAction()
    {
        $user = Auth::user();
        if ($user->role !== 'admin' && $this->domain->customer_id !== $user->id) {
            abort(403);
        }
    }

    public function createRecord(SynergyClient $synergy)
    {
        $this->authorizeAction();
        $this->validate();
        $record = $this->domain->dnsRecords()->create([
            'type' => $this->type,
            'name' => $this->name,
            'value' => $this->value,
            'ttl' => $this->ttl,
        ]);

        $synergy->addDNSRecord([
            'domainName' => $this->domain->domain_name,
            'recordType' => $record->type,
            'host' => $record->name,
            'value' => $record->value,
            'ttl' => $record->ttl,
        ]);

        $this->reset(['type', 'name', 'value', 'ttl']);
    }

    public function editRecord($id)
    {
        $this->authorizeAction();
        $record = DnsRecord::findOrFail($id);
        $this->recordId = $record->id;
        $this->type = $record->type;
        $this->name = $record->name;
        $this->value = $record->value;
        $this->ttl = $record->ttl;
    }

    public function updateRecord(SynergyClient $synergy)
    {
        $this->authorizeAction();
        $this->validate();
        $record = DnsRecord::findOrFail($this->recordId);
        $record->update([
            'type' => $this->type,
            'name' => $this->name,
            'value' => $this->value,
            'ttl' => $this->ttl,
        ]);

        $synergy->updateDNSRecord([
            'domainName' => $this->domain->domain_name,
            'recordID' => $record->id,
            'recordType' => $record->type,
            'host' => $record->name,
            'value' => $record->value,
            'ttl' => $record->ttl,
        ]);

        $this->reset(['recordId', 'type', 'name', 'value', 'ttl']);
    }

    public function deleteRecord($id, SynergyClient $synergy)
    {
        $this->authorizeAction();
        $record = DnsRecord::findOrFail($id);
        $record->delete();

        $synergy->deleteDNSRecord([
            'domainName' => $this->domain->domain_name,
            'recordID' => $id,
        ]);
    }

    public function render()
    {
        $records = $this->domain->dnsRecords()->get();
        return view('livewire.dns-records', [
            'records' => $records,
        ]);
    }
}
