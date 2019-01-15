@extends('layouts.app')
@section('title')
Work With Us
@endsection
@section('content')

<div class="img-work">
  <img class="img-apparel" src="images/Work-with-us-printing-lab.jpg" alt="">
</div>

<div class="container ctn-txt">
  <div class="col-md-12">
    <h1>WORK WITH US</h1>
  </div>
</div>
<div class="container">
  <div class="row row-work-apparel">
    <div class="col-md-8 col-sm-8 col-12">
      <h4><strong>INSIDE SALES OFFICE MANAGER</strong></h4>
      <h5><strong>Printing Lab - West New York, NJ</strong></h5>
      <p>
        A Position is now available at Printing Lab located in West New York, NJ
      </p>
      <p>
        Printing Lab, is a leading North Jersey full service Printing, Design, & Marketing Solutions company seeking to fill the following full time position:
      </p>
      <p>
        <strong>
          INSIDE SALES OFFICE MANAGER
        </strong>
      </p>
      <p>The successful applicant must be a proven leader, fully capable of motivating and managing a team of sales representatives who must meet or exceed the targets set
        by utilizing diversified strategies.</p>
        <p>
          He/She must be detail oriented, reliable and organized, with excellent interpersonal skills.
        </p>
        <p>
          Candidate must be self-motivated and able to learn new products and strategies, train new Representatives and work with everyone on the staff
        </p>
        <p>
          The position will oversee personnel and set targets.
        </p>
        <p>
          Manager is to ensure the success of the company’s Inside Sales Office and its Team.
          He/She will hire, train and manage the professional development of an inside team, which consists of individuals who conduct sales via walk-in, telemarketing, direct
          mail, and web-based strategies.
        </p>
        <p>
          Candidate must be able to set goals, track, produce sales reports, complete monthly forecasting and set department budgets.
        </p>
        <p>
          Manager must conduct analyses to determine prospective clients and develop relationships with existing clients.This position requires a full commitment and
          dedication as a leader who can earn respect as a good communicator and mentor.
        </p>
        <p>
          Candidate must attend Company meetings as well as schedule regular and consistent meetings with his/her team.
        </p>
        <p>
          He/She will resolve product or service problems by clarifying customer complaints determining the cause of the problem; selecting and explaining the best solution to
          solve the problem; expediting correction or adjustment; following up with his/her staff to ensure quick customer complaint resolution.
          Candidate must be able to maintain financial accounts by processing customer adjustments.Recommends potential products or services to management by collecting
          customer information and analyzing customer needs.
        </p>
        <p>
          Inside Sales Office Manager will prepare product or service reports by collecting and analyzing customer information.
        </p>
        <p>
          <strong>
            SKILLS:
          </strong>
        </p>
        <p>
          Customer Service experience, Product Knowledge, Quality Focus, Problem Solving, Market Knowledge, Documentation Skills, Listening, Phone Skills, Resolving Conflict,
          Analyzing Information , Multi-tasking
        </p>
        <p>
          <strong>
            GENERAL REQUIREMENTS:
          </strong>
        </p>
        <ul>
          <li>Clean Driver's License</li>
          <li>Bilingual Spanish/English would be required.</li>
          <li>Candidates must be available to work on-site at our West New York, NJ location.</li>
          <li>Job Stability and Growth</li>
          <li>Upward mobility</li>
          <li>Salary starts between $40K and $50K and is determined by job experience and results achieved.</li>
        </ul>
        <p><strong>JOB TYPE:</strong></p>
        <p>Full-time</p>
        <p><strong>EXPERIENCE:</strong></p>
        <p>Customer Service: 2 years (Preferred)</p>
        <p>Managing Employees: 3 years (Preferred)</p>
        <p><strong>LICENSE:</strong></p>
        <p>Driver's License (Preferred)</p>
        <p><strong>LANGUAGE:</strong></p>
        <p>English (Required)</p>
        <p>Spanish (Required)</p>
      </div>
      <div class="col-md-4 col-sm-4 col-12">
        <form class="" action="{{route('WorkEmail')}}" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          <div class="col-md-12">
            <h3><strong>JOIN US</strong></h3>
            <h6><strong>Please complete this form</strong></h6>
          </div>
          <div class="col-md-12">
            <input class="workinput" placeholder="Full Name*" type="text" name="nombre" required>
          </div>
          <div class="col-md-12">
            <input class="workinput" placeholder="Phone*" type="tel" name="telefono" required>
          </div>
          <div class="col-md-12">
            <input class="workinput" placeholder="E-mail*" type="email" name="email" required>
          </div>
          <div class="col-md-12">
            <select class="select-work" name="Job" required>
              <option value="Job">Job</option>
              <option value="Inside sales office manager" class="optfield">Inside sales office manager</option>
            </select>
          </div>
          <div class="col-md-12">
            <textarea placeholder="Message*" id="text" class="text-work" rows="2" name="comentario" required></textarea>
          </div>
          <div class="col-md-12">
            <div class="file_work">
              <p>Upload Your File</p>
              <input type="file" id="archivounouno" name="archivo">
              <div class="output_work">
                <p></p>
              </div>
            </div>
          </div>
          <div class="col-md-12 ">
            <input type="submit" value="SEND" class="bnt_Swork">
          </div>
        </form>
      </div>
    </div>
  </div>

  @endsection

@section('scripts')
<script>
$('#archivounouno').on('change', function(e){
  //validación peso del archivo en by
  var input = document.getElementById('archivounouno');
  var clicked = e.target;
  var file = clicked.files[0];
  if (file.size>5000000 )
  {
    $('.output_work p').text('');
    $("#archivounouno").val('');
    $.confirm({
      title: 'Alert!',
      content: 'The file can not exceed 5Mb',
      draggable: false,
      buttons: {
        confirm: function () {
        },
      }
    })
  }else {
    var filePath = 	document.getElementById('archivounouno').value;
    var allowedExtensions = /(.pdf|.PNG|.PDF|.jpeg|.doc|.docx)$/i;
    //validacion extension
    if (!allowedExtensions.exec(filePath)) {
      $('.output_work p').text('');
      $("#archivounouno").val('');
      $.confirm({
        title: 'Alert!',
        content: 'The extension of the file is not allowed',
        draggable: false,
        buttons: {
          confirm: function () {
          },
        }
      })
    }else{
      var ruta = $(this).val();
      var substr = ruta.replace('C:\\fakepath\\', '');
      $('.output_work p').text(substr);
      $('.output_work').css({
        "opacity": 1,
        "transform": "translateY(0px)"
      });
      $('.file > p').addClass('change');
    }
  }
});
</script>
@endsection
