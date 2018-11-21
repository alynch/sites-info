 <div class="card mb-3">
    <div class="card-header">
        <h5>Peak periods</h5>
    </div>

    <timeline-picker
        :all_year="{{ $application->all_year ?? 0 }}"
        :periods="{{ $application->timeline }}">
    </timeline-picker>
</div>
