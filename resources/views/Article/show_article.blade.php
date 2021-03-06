@extends('layouts.main')

@section('title')
{{ucfirst($article->title)}} - {{ucfirst($article->writtenBy->fname)}} {{ucfirst($article->writtenBy->lname)}}  | fluidbN
@endsection

  
    

@section('content')


<div class="container">

    <div class="row featurette">
   

        <div class="col-sm-6 ">
          
          <div class="box" id="mainView" data-articleid="{{$article->id}}" >
              
         
          
         
              <a href="{{route('profile',['user'=>$article->writtenBy,'slug'=>str_slug($article->writtenBy->fname." ".$article->writtenBy->lname)])}}">
              <img class="featurette-image img-fluid mx-auto  propic" src="/storage/profile_images/{{$article->writtenBy->hasProfile->profile_image}}" alt=""><h5 class="writer">{{ucfirst($article->writtenBy->fname)}}
              {{ucfirst($article->writtenBy->lname)}}</h5></a>
          
             
              <h6 class="writer-small" style="margin-top:5px;">{{$article->writtenBy->hasProfile->about }}</h6>
              @php
          $f = Auth::user()->follows()->wherePivot('follower_id',Auth::user()->id)->wherePivot('following_id',$article->writtenBy->id)->first();
         $l = Auth::user()->likes()->wherePivot('user_id',Auth::user()->id)->wherePivot('article_id',$article->id)->first();
          if($f)
           $cl="pressed";
           else
           $cl="";
           if($l)
           $c="pressed";
           else
           $c="";
         
          @endphp
           <button class="btn margin btn-login fol {{$cl}}" id ="" data-userid="{{$article->writtenBy->id}}">{{$follow ? "Following" : "Follow"}}</button> 
            
  
              @if (Auth::user()->id==$article->writtenBy->id) 
            
            <button  class="btn  btn-login margin"  onclick="location.href='{{route('view-edit',['article'=>$article])}}'">Open in edit view</button> 
      
           @endif
               </div>
        <table class="table table-bordered table-hover">
                
                    <tbody id="fol_sugg">
                    
                    </tbody>
                     
                    </table>
      </div>
      
     <div class="col-sm-4">
     
              <div class="frame">    
            <img class="featurette-image img-fluid mx-auto" src="/storage/article_images/{{$article->title_image}}"alt="">
              </div>
     </div>
    </div>
</div>
     
      @php
      if($views>1)
      $v = $views.' views';
     else if($views==0)
     $v = "";
      else
      $v = $views.' view';
      if($wows==0)
      $w = '';
      else if($wows==1)
      $w = '  '.$wows.' wow';
      else
      $w = '  '.$wows.' wows';
      
      @endphp
      <div class="container">
      <div class="row">
      
      
      
      <div class="col-md-12">
          <h2 class="featurette-heading" style="margin-top:20px; color:black;">{{ucfirst($article->title)}}</h2>
          <small class="writer">{{$article->created_at->format('d F Y')}}</small> <small class="views right-wow"> {{$v}}</small> <small class="views right-wow" id="wow"> {{$w}}</small>       <hr class="featurette-divider">
          <blockquote class="blockquote">
          <p>{!!$article->content!!}</p>
         
           
        </blockquote>   
          </div
           </div>
           <div class="row">
          @if(count($articleImages)>0)
          @foreach($articleImages as $ai)
      <div class="col-md-4">
      
          <img class="featurette-image img-fluid mx-auto" src="/storage/article_images/{{$ai->image}}" id="multi-img"alt="" style="box-shadow: 5px 5px 5px #888888;width:auto;height:auto;">
          
          </div>
          @endforeach
          @endif
      </div>
  
   

      <footer>
          <div class="box lower-margin">
              <button class="btn  btn-login {{$c}}" id="like"  style="margin-left:20px;margin-top:5px;" data-articleid="{{$article->id}}" type="submit">{{$like ? "Thanks" : "Wow"}}</button>
          <button class="btn   btn-login bookmark" style="margin-top:5px;" data-articleId="{{$article->id}}">{{$bookmark ? "Bookmarked" : "Bookmark"}}</button>
          
        </div>
        {{--
        <button class="btn btn-login" style="margin-top:5px;margin-bottom:10px;" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::fullUrl()) }}')">Share on facebook</button>
        <button class="btn   btn-login" style="margin-top:5px;margin-bottom:10px;" onclick="window.open('https://twitter.com/intent/tweet?url={{ urlencode(Request::fullUrl())}}')">Share on twitter</button>
       --}}
  
         
          @if(count($related_articles)>0)
          <div class="lower-margin">
          <h2 class="featurette-heading"style="color:black;margin-left:20px;">More wonderful stories in {{ucfirst($article->ofGenre->name)}}...!   @if(count($related_articles)==3) <a href="{{route('stories-genre',['genre'=>$article->ofGenre])}}">See all</a>@endif</h2>
          </div>
          <div class="row featurette" style="margin-left:6px;">
            @foreach ( $related_articles as $ra )
           
              <div class="col-md-4">
            
                <a href="{{route('show-article',['article'=>$ra,'slug'=>str_slug($ra->title)])}}">
                <div class="card-related" style="width:100%;">
                  <img class="featurette-image img-fluid mx-auto img-card" src="/storage/article_images/{{$ra->title_image}}" alt="">
                  <div class="container-related lower-margin" style="width:100%;">
                    <h2  class="featurette-heading-small"style="font-size:25px;font-weight:bold;">{{ucfirst($ra->title)}}</h2>
                   
                    <p class="lead">{!!wordwrap(str_limit($ra->content,50),20,"<br>\n",TRUE)!!}</p> @if($ra->views>0)<small class="views"> {{ '   '.$ra->views.' views'}}</small>@endif
                    <div class="">
                      <img class="featurette-image img-fluid mx-auto  propic-small" src="/storage/profile_images/{{$ra->writtenBy->hasProfile->profile_image}}" alt=""> <small class="writer-small"><a href="{{route('profile',['user'=>$ra->writtenBy,'slug'=>str_slug($ra->writtenBy->fname." ".$ra->writtenBy->lname)])}}">{{ucfirst($ra->writtenBy->fname).' '. ucfirst($ra->writtenBy->lname)}}</a></small><div class=""><small class="margin writer-small">{{$ra->writtenBy->hasProfile->about }}</small></div>
                       </div>  
                  </div>
                </div>
                </a>
               
                  <br/>
                  
                  
           </div>
      

            @endforeach
        
          </div>
            @endif
         
            @if(Auth::user()->id != $article->writtenBy->id)
          @if(count($articles_of_samewriter)>0)
          <div class="lower-margin">
          <h2 class="featurette-heading"style="color:black;margin-left:20px;">More cool stories from {{ucfirst($article->writtenBy->fname)}}...!  @if(count($articles_of_samewriter)==3)<a href="{{route('stories-user',['user'=>$article->writtenBy])}}">See all</a>@endif</h2>
          </div>
          <div class="row featurette"  style="margin-left:6px;">
            @foreach ( $articles_of_samewriter as $ra )
               
            <div class="col-md-4">
       
              <div class="">
                <a href="{{route('stories-genre',['genre'=>$ra->ofGenre])}}" <small class="genre-feed">{{ucfirst($ra->ofGenre->name)}}</small></a>
              </div>
               
                <a href="{{route('show-article',['article'=>$ra,'slug'=>str_slug($ra->title)])}}">
                <div class="card-related" style="width:100%;">
                  <img class="featurette-image img-fluid mx-auto img-card" src="/storage/article_images/{{$ra->title_image}}" alt="">
                  <div class="container-related lower-margin" style="width:100%;">
                    <h2  class="featurette-heading-small"style="font-size:25px;font-weight:bold;">{{ucfirst($ra->title)}}</h2>
                   
                   <p class="lead">{!!wordwrap(str_limit($ra->content,50),20,"<br>\n",TRUE)!!}</p> @if($ra->views>0)<small class="views"> {{ '   '.$ra->views.' views'}}</small>@endif
                  </div>
                </div>
                </a>
               
                  <br/>
                  
                  
           </div>
      
                       
                
            @endforeach
            </div>
          
          @endif
         @endif 
{{--
         <div class="">

          

            <button  class="btn   btn-login" style="margin-left:20px;" id="comment"  data-toggle="modal" data-target="#commenton">
           Write a word of appreciation
            </button>
          
            <!-- The Modal -->
            <div class="modal fade" id="commenton">
              <div class="modal-dialog">
                <div class="modal-content">
                
                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title writer">{{ucfirst(Auth::user()->fname).' express your words of appreciation to '.ucfirst($article->writtenBy->fname) }} !</h4>
                   
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  
                  <!-- Modal body -->
                  <div class="modal-body">
                   
                  {!! Form::open(['route'=>['comment',$article->id],'method'=>'POST']) !!} 
                     
          
                          
                       
                          <div class="form-group">
               
                  {{Form::textarea('comment','',['class'=>'form-control','placeholder'=>'Share your words of appreciation...','id'=>'commentarea'])}}
                  </div>
                 
                  {{Form::submit('Done',['class'=>'btn  ','id'=>'commentSubmit'])}}
                  
                         
                       
                         {!! Form::close() !!}
                  </div>
                  
            
                  
                </div>
              </div>
            </div>
            
          
       </div>
       --}}
                       
       
         
       </div>
        </footer>
    </div>
  
<script>
    @include('includes.buttons') 
</script>
    <script>
        $('ul.pagination').hide();
        $(function() {
            $('.infinite').jscroll({
                autoTrigger: true,
                loadingHtml: '<img class="center-block" src="/loader_images/image_1212462.gif" alt="Loading..." />',
                padding: 0,
                nextSelector: '.pagination li.active + li a',
                contentSelector: 'div.infinite',
                callback: function() {
                    $('ul.pagination').remove();
                   }
                 });
              });
        
      </script> 
  






@endsection


