@extends('layouts.app')

@section('title', 'Alumni Dashboard')

@push('style')
   <link rel="stylesheet" href="{{ asset('assets/modules/chartjs/Chart.min.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
@endpush

@section('main')
   <div class="main-content">
      <section class="section">
        <div class="section-header">
          <h1>Dashboard</h1>
        </div>

        <div class="section-body">
          <!-- Profile Completeness Alert -->
          <div class="row mb-3">
            <div class="col-12">
               @if(isset($isComplete) && !$isComplete)
               <div class="card border-left-warning shadow h-100 py-2" style="border-left: 4px solid #f6c23e;">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                   <div class="col-auto mr-3">
                     <i class="fas fa-user-edit fa-2x text-warning"></i>
                   </div>
                   <div class="col">
                     <div class="h5 mb-1 font-weight-bold text-warning">Complete Your Profile</div>
                     @if(isset($missingFiles) && count($missingFiles) > 0)
                     <div class="d-flex justify-content-between align-items-center mb-1">
                      <span>Completion Status</span>
                      <span class="badge badge-warning">
                        {{ isset($completionPercentage) ? $completionPercentage : 0 }}%
                      </span>
                     </div>
                     <div class="progress mb-2" style="height: 10px;">
                      <div class="progress-bar bg-warning" role="progressbar"
                        style="width: {{ isset($completionPercentage) ? $completionPercentage : 0 }}%"
                        aria-valuenow="{{ isset($completionPercentage) ? $completionPercentage : 0 }}"
                        aria-valuemin="0" aria-valuemax="100"></div>
                     </div>
                     <p class="mb-1">
                      Missing items ({{ count($missingFiles) }} of {{ isset($totalItems) ? $totalItems : 6 }}):
                     </p>
                     <div class="row mb-3">
                      @foreach($missingFiles as $item)
                     <div class="col-md-6 col-lg-4 mb-1">
                     <div class="d-flex align-items-center">
                      <i class="fas fa-times-circle text-danger mr-2"></i>
                      <span>{{ $item }}</span>
                     </div>
                     </div>
                   @endforeach
                     </div>
                  @endif
                     <a href="{{ route('alumni.profile') }}" class="btn btn-warning">
                       <i class="fas fa-arrow-right mr-1"></i> Complete Profile Now
                     </a>
                   </div>
                  </div>
                </div>
               </div>
            @else
               <div class="card border-left-success shadow h-100 py-2" style="border-left: 4px solid #1cc88a;">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                   <div class="col-auto mr-3">
                     <i class="fas fa-check-circle fa-2x text-success"></i>
                   </div>
                   <div class="col">
                     <div class="h5 mb-1 font-weight-bold text-success">Your Profile is Complete!</div>
                     <div class="d-flex justify-content-between align-items-center mb-1">
                       <span>Completion Status</span>
                       <span class="badge badge-success">100%</span>
                     </div>
                     <div class="progress mb-3" style="height: 10px;">
                       <div class="progress-bar bg-success" role="progressbar" style="width: 100%"
                        aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                     </div>
                     <p class="mb-3">
                       Thank you for completing your profile data. You are now ready to register for exams!
                     </p>
                     <a href="{{ route('alumni.profile') }}" class="btn btn-success">
                       <i class="fas fa-user mr-1"></i> View Profile
                     </a>
                   </div>
                  </div>
                </div>
               </div>
            @endif
            </div>
          </div>

          <!-- PDF Announcement Section -->
          @if(isset($announcements) && $announcements && $announcements->announcement_file)
           <div class="row mb-3">
            <div class="col-12">
               <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex align-items-center">
                  <i class="fas fa-file-pdf mr-2"></i>
                  <strong style="font-size:16px;">PDF Announcement</strong>
                </div>

                <div class="card-body py-3">
                  <div class="announcement-pdf-container">
                   <div class="row">
                     <div class="col-md-8">
                       <h5 class="text-primary mb-2">{{ $announcements->title }}</h5>
                       <p class="text-muted mb-3">
                        <small><i class="fas fa-calendar-alt mr-1"></i> Posted on
                          {{ $announcements->announcement_date->format('d M Y') }}</small>
                       </p>
                       <p class="mb-3">{{ $announcements->content }}</p>
                     </div>
                     <div class="col-md-4 text-center d-flex flex-column justify-content-center">
                       <div class="pdf-icon mb-3">
                        <i class="fas fa-file-pdf text-danger" style="font-size: 4rem;"></i>
                       </div>
                       <div class="btn-group-vertical">
                        <a href="{{ $announcements->announcement_file }}" class="btn btn-primary mb-2"
                          target="_blank">
                          <i class="fas fa-eye mr-1"></i> View PDF
                        </a>
                        <a href="{{ $announcements->announcement_file }}" class="btn btn-outline-primary"
                          download>
                          <i class="fas fa-download mr-1"></i> Download PDF
                        </a>
                       </div>
                     </div>
                   </div>

                   <!-- PDF Preview -->
                   <div class="pdf-preview mt-4">
                     <div class="card">
                       <div class="card-header bg-light">
                        <h6 class="mb-0">PDF Preview</h6>
                       </div>
                       <div class="card-body p-0">
                        <div class="embed-responsive embed-responsive-16by9">
                          <iframe class="embed-responsive-item" src="{{ $announcements->announcement_file }}"
                            allowfullscreen></iframe>
                        </div>
                       </div>
                     </div>
                   </div>
                  </div>
                </div>
               </div>
            </div>
           </div>
         @endif

          <!-- Announcement -->
          <div class="row mb-3">
            <div class="col-12">
               <div class="card shadow-sm border-0">
                 <div class="card-header bg-primary text-white d-flex align-items-center">
                   <i class="fas fa-bullhorn mr-2"></i>
                   <strong style="font-size:16px;">Announcements</strong>
                 </div>
                 <div class="card-body py-3">
                   @if ($announcements)
                  <div class="announcement-container">
                   <div class="d-flex justify-content-between align-items-center mb-2">
                     <h4 class="text-primary mb-0">{{ $announcements->title }}</h4>
                     <span class="badge badge-primary">
                       {{ isset($announcements->announcement_date) ? \Carbon\Carbon::parse($announcements->announcement_date)->format('d M Y') : '' }}
                     </span>
                   </div>
                   <div class="announcement-content p-3 bg-light rounded">
                     <p class="mb-0">{{ $announcements->content }}</p>
                   </div>
                   <div class="d-flex justify-content-end mt-2">
                     <small class="text-muted">
                       <i class="fas fa-clock mr-1"></i> Posted
                       {{ isset($announcements->announcement_date) ? \Carbon\Carbon::parse($announcements->announcement_date)->diffForHumans() : 'Unknown date' }}
                     </small>
                   </div>
                  </div>
               @else
                  <div class="text-center py-4">
                   <i class="fas fa-info-circle fa-3x text-muted mb-3"></i>
                   <h5 class="text-muted">No Announcements</h5>
                   <p class="text-muted mb-0">
                     There are no announcements at this time. Check back later!
                   </p>
                  </div>
               @endif
                 </div>
               </div>
            </div>
          </div>

          <!-- Row: Exam Schedule & Exam Scores -->
          <div class="row">
            <!-- Exam Schedule -->
            <div class="col-md-6">
               <div class="card shadow-sm border-0" style="margin-bottom:15px;">
                 <div class="card-header bg-light d-flex align-items-center justify-content-between py-3">
                   <div>
                     <i class="fas fa-calendar-alt text-primary mr-2"></i>
                     <strong style="font-size:16px;">Exam Schedule</strong>
                   </div>
                   @if(count($schedules) > 0)
                  <span class="badge badge-primary">{{ count($schedules) }} Upcoming</span>
               @endif
                 </div>
                 <div class="card-body p-0">
                   @if(count($schedules) > 0)
                  <div class="table-responsive">
                   <table class="table table-hover mb-0">
                     <thead class="thead-light">
                       <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">
                          <i class="far fa-calendar mr-1 text-muted"></i> Date
                        </th>
                        <th class="px-4 py-3">
                          <i class="far fa-clock mr-1 text-muted"></i> Time
                        </th>
                        <th class="px-4 py-3">Action</th>
                       </tr>
                     </thead>
                     <tbody>
                       @foreach($schedules as $i => $schedule)
                        @php
                      $examDate = $schedule->exam_date ?? \Carbon\Carbon::parse($schedule->exam_time)->format('Y-m-d');
                      $examTime = \Carbon\Carbon::parse($schedule->exam_time)->format('H:i');
                      $isToday = \Carbon\Carbon::parse($examDate)->isToday();
                    @endphp
                        <tr class="{{ $isToday ? 'bg-light-success' : '' }}">
                         <td class="px-4 py-3">{{ $schedules->firstItem() + $i }}</td>
                         <td class="px-4 py-3">
                          <strong>{{ \Carbon\Carbon::parse($examDate)->format('d M Y') }}</strong>
                          @if($isToday)
                        <span class="badge badge-success ml-2">Today</span>
                       @endif
                         </td>
                         <td class="px-4 py-3">
                          <span class="text-primary">{{ $examTime }}</span>
                         </td>
                         <td class="px-4 py-3">
                          <a href="{{ $schedule->zoom_link }}" target="_blank"
                            class="btn btn-primary btn-sm rounded-pill px-3">
                            <i class="fas fa-video mr-1"></i> Join Zoom
                          </a>
                         </td>
                        </tr>
                   @endforeach
                     </tbody>
                   </table>
                  </div>
                  <div class="px-4 py-3 border-top">
                   {{ $schedules->links() }}
                  </div>
               @else
                  <div class="text-center py-5">
                   <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                   <h5 class="text-muted">No Exams Scheduled</h5>
                   <p class="text-muted mb-0">
                     There are no upcoming exams scheduled at this time.
                   </p>
                  </div>
               @endif
                 </div>
               </div>
            </div>

            <!-- My TOEIC Results -->
            <div class="col-md-6">
               <div class="card shadow-sm border-0">
                 <div class="card-header bg-light d-flex align-items-center justify-content-between py-3">
                   <div>
                     <i class="fas fa-chart-line text-primary mr-2"></i>
                     <strong style="font-size:16px;">My TOEIC Results</strong>
                   </div>
                   @if(count($examScores) > 0)
                  <span class="badge badge-primary">{{ count($examScores) }} Results</span>
               @endif
                 </div>
                 <div class="card-body p-0">
                   @if(count($examScores) > 0)
                  <div class="table-responsive">
                   <table class="table table-hover mb-0">
                     <thead class="thead-light">
                       <tr>
                        <th class="px-4 py-3">Exam ID</th>
                        <th class="px-4 py-3">
                          <i class="fas fa-headphones mr-1 text-muted"></i> Listening
                        </th>
                        <th class="px-4 py-3">
                          <i class="fas fa-book-open mr-1 text-muted"></i> Reading
                        </th>
                        <th class="px-4 py-3">
                          <i class="fas fa-trophy mr-1 text-muted"></i> Total
                        </th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Date</th>
                       </tr>
                     </thead>
                     <tbody>
                       @foreach($examScores as $result)
                      <tr>
                        <td class="px-4 py-3">
                        <strong class="text-primary">{{ $result->exam_id ?? 'N/A' }}</strong>
                        </td>
                        <td class="px-4 py-3">
                        <span class="badge badge-info">{{ $result->listening_score ?? 0 }}</span>
                        </td>
                        <td class="px-4 py-3">
                        <span class="badge badge-info">{{ $result->reading_score ?? 0 }}</span>
                        </td>
                        <td class="px-4 py-3">
                        <span
                          class="badge {{ ($result->total_score ?? 0) >= 500 ? 'badge-success' : 'badge-danger' }}">
                          {{ $result->total_score ?? 0 }}
                        </span>
                        </td>
                        <td class="px-4 py-3">
                        @if(($result->total_score ?? 0) >= 500)
                      <span class="badge badge-success">
                        <i class="fas fa-check mr-1"></i> PASS
                      </span>
                     @else
                      <span class="badge badge-danger">
                        <i class="fas fa-times mr-1"></i> FAIL
                      </span>
                     @endif
                        </td>
                        <td class="px-4 py-3">
                        <small class="text-muted">
                          {{ $result->exam_date ? $result->exam_date->format('d M Y') : ($result->created_at ? $result->created_at->format('d M Y') : 'N/A') }}
                        </small>
                        </td>
                      </tr>
                   @endforeach
                     </tbody>
                   </table>
                  </div>
               @else
                  <div class="text-center py-5">
                   <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                   <h5 class="text-muted">No TOEIC Results Yet</h5>
                   <p class="text-muted mb-0">
                     Your TOEIC exam results will appear here once they are uploaded by the administrator.
                   </p>
                  </div>
               @endif
                 </div>
               </div>
            </div>
          </div>

        </div>
      </section>
   </div>
@endsection

@push('scripts')
   <script src="{{ asset('assets/modules/chartjs/Chart.min.js') }}"></script>
   <script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
   <script>
      // Dashboard ready
      $(document).ready(function () {
        console.log('Alumni dashboard loaded successfully');
      });
   </script>
@endpush