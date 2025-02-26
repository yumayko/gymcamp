@extends('layouts.app')
@section('title') {{$gym->name}} Details @endsection
@section('content')
<div id="background" class="absolute w-full h-[355px] top-0 z-0 bg-[#9FDDFF]"></div>
<x-nav/>
    <main id="content" class="relative flex w-full max-w-[1280px] gap-6 mx-auto px-10 mt-[96px]">
        <section id="details" class="flex flex-col gap-6 w-full max-w-[820px] flex-1">
            <div id="main-thumbnail" class="w-full h-[453px] rounded-3xl bg-[#06425E] overflow-hidden">
                <img src="{{Storage::url($gym->thumbnail)}}" class="w-full h-full object-cover" alt="main thumbnail">
            </div>
            <div id="gallery" class="grid grid-cols-4 gap-4">
                @foreach ($gym->gymPhotos as $itemPhoto)
                <button class="w-full rounded-2xl bg-[#D9D9D9] overflow-hidden transition-all duration-300 opacity-50">
                    <img src="{{Storage::url($itemPhoto->photo)}}" class="w-full h-full object-cover" alt="thumbnail">
                </button>
                
                @endforeach
            </div>
            <div id="place-info" class="flex flex-col w-full rounded-3xl p-8 gap-12 bg-white">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex flex-col gap-2">
                        <h1 class="font-['ClashDisplay-SemiBold'] text-[32px] leading-[40px] tracking-05">{{$gym->name}}</h1>
                        <div class="flex items-center gap-2">
                            <img src="{{asset('assets/images/icons/location-puple.svg')}}" class="flex shrink-0" alt="icon">
                            <p class="text-xl leading-6 tracking-05 opacity-50">{{$gym->city->name}}</p>
                        </div>
                    </div>
                    @if($gym->is_popular)
                    <p class="rounded-full py-3 px-6 bg-[#E56062] w-fit font-semibold leading-19 tracking-05 text-white">Popular</p>
                    @endif
                </div>
                <div class="flex flex-col gap-6">
                    <h2 class="font-['ClashDisplay-SemiBold'] text-xl leading-6 tracking-05">Facilities Available</h2>
                    <hr class="opacity-10 border-black">
                    <div class="grid grid-cols-3 gap-x-8 gap-y-6">
                        @foreach ($gym->gymFacility as $itemFacility)
                        
                        <div class="flex items-center gap-2">
                            <img src="{{Storage::url($itemFacility->facility->thumbnail)}}" class="w-[56px] h-[56px] flex shrink-0" alt="icon">
                            <div class="flex flex-col gap-2">
                                <p class="font-['ClashDisplay-SemiBold'] leading-19 tracking-05">{{$itemFacility->facility->name}}</p>
                                <p class="text-sm leading-16 tracking-05 opacity-50">{{$itemFacility->facility->about}}</p>
                            </div>
                        </div>

                        @endforeach
                    </div>
                </div>
                <div class="flex flex-col gap-6">
                    <h2 class="font-['ClashDisplay-SemiBold'] text-xl leading-6 tracking-05">Description</h2>
                    <hr class="opacity-10 border-black">
                    <p class="leading-[34px] tracking-05">{{$gym->about}}</p>
                </div>
                <div class="flex items-center gap-8">
                    <div class="flex items-center gap-3 shrink-0">
                        <img src="{{asset('assets/images/icons/Daily Time.svg')}}" class="w-20 h-20 flex shrink-0" alt="icon">
                        <div class="flex flex-col gap-2">
                            <p class="font-['ClashDisplay-SemiBold'] text-xl leading-6 tracking-05">Opening Work</p>
                            <p class="text-sm leading-19 tracking-05 opacity-50 text-nowrap">{{$gym->open_time_at->format('h:i A')}} - {{$gym->closed_time_at->format('h:i A')}}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-8">
                        <img src="{{asset('assets/images/icons/Adress.svg')}}" class="w-20 h-20 flex shrink-0" alt="icon">
                        <div class="flex flex-col gap-3">
                            <p class="font-['ClashDisplay-SemiBold'] text-xl leading-6 tracking-05">Detail Address</p>
                            <p class="leading-[22px] tracking-05 opacity-50">{{$gym->address}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="reviews" class="flex flex-col w-full rounded-3xl p-8 gap-8 bg-white">
                <div class="flex flex-col gap-4">
                    <h2 class="font-['ClashDisplay-SemiBold'] text-[48px] leading-[59px] tracking-05">Happy Stories</h2>
                    <p class="leading-19 tracking-03 opacity-60">What they said about this gym location, facilities, and environtment</p>
                </div>
                <div class="grid grid-cols-2 gap-4 px-[27px]">
                    @foreach ($gym->gymTestimonials as $itemTestimonial)
                    <div class="font-['Poppins'] flex flex-col w-full rounded-3xl border border-[#E4E4E4] py-4 px-6 gap-3 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full border-[5px] border-white overflow-hidden">
                                <img src="{{Storage::url($itemTestimonial->photo)}}" class="w-full h-full object-cover" alt="photo">
                            </div>
                            <div class="flex flex-col gap-1">
                                <p class="font-semibold text-sm leading-[22px] tracking-03">{{$itemTestimonial->name}}</p>
                                <p class="text-xs leading-5 tracking-03 text-[#8D9397]">{{$itemTestimonial->occupation}}</p>
                            </div>
                        </div>
                        <p class="text-sm leading-[22px] tracking-03">{{$itemTestimonial->message}}</p>
                        <div class="flex items-center gap-1">
                            <img src="{{asset('assets/images/icons/magic-star.svg')}}" class="w-4 h-4" alt="icon">
                            <img src="{{asset('assets/images/icons/magic-star.svg')}}" class="w-4 h-4" alt="icon">
                            <img src="{{asset('assets/images/icons/magic-star.svg')}}" class="w-4 h-4" alt="icon">
                            <img src="{{asset('assets/images/icons/magic-star.svg')}}" class="w-4 h-4" alt="icon">
                            <img src="{{asset('assets/images/icons/magic-star.svg')}}" class="w-4 h-4" alt="icon">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        <aside class="flex flex-col gap-6">
            <div class="flex flex-col w-full rounded-3xl p-8 gap-6 bg-white">
                <p class="font-['ClashDisplay-SemiBold'] leading-19 tracking-05">Access All Member Benefits</p>
                <div class="flex w-full h-[200px] rounded-3xl overflow-hidden bg-[#606DE5]">
                    <img src="{{asset('assets/images/thumbnails/Regular.png')}}" class="w-full h-full object-cover" alt="icon">
                </div>
                <div class="flex items-center gap-4">
                    <img src="{{asset('assets/images/icons/tick-circle.svg')}}" class="w-8 h-8 flex shrink-0" alt="icon">
                    <p class="leading-19 tracking-05">Gym Facility Access</p>
                </div>
                <div class="flex items-center gap-4">
                    <img src="{{asset('assets/images/icons/tick-circle.svg')}}" class="w-8 h-8 flex shrink-0" alt="icon">
                    <p class="leading-19 tracking-05">All Class Enrollment</p>
                </div>
                <div class="flex items-center gap-4">
                    <img src="{{asset('assets/images/icons/tick-circle.svg')}}" class="w-8 h-8 flex shrink-0" alt="icon">
                    <p class="leading-19 tracking-05">Workshop & Discount</p>
                </div>
                <div class="flex items-center gap-4">
                    <img src="{{asset('assets/images/icons/tick-circle.svg')}}" class="w-8 h-8 flex shrink-0" alt="icon">
                    <p class="leading-19 tracking-05">Personal Training Sessions</p>
                </div>
                <a href="{{route('front.pricing')}}" class="rounded-full py-3 px-6 bg-[#606DE5] font-semibold leading-19 tracking-05 text-white text-center">Become Member</a>
            </div>
            <div class="flex flex-col w-full rounded-3xl p-8 gap-4 bg-white">
                <p class="font-['ClashDisplay-SemiBold'] leading-19 tracking-05">Contact Person</p>
                <hr class="border-black opacity-10">
                <div class="flex items-center gap-3">
                    <div class="flex w-10 h-10 rounded-full overflow-hidden">
                        <img src="{{asset('assets/images/photos/Image-4.png')}}" class="w-full h-full object-cover" alt="photo">
                    </div>
                    <div class="flex flex-col gap-2">
                        <p class="font-['ClashDisplay-SemiBold'] text-sm leading-17 tracking-05">Lili Marlili Trilili</p>
                        <p class="text-xs leading-14 tracking-05 opacity-50">021-256-7854</p>
                    </div>
                </div>
            </div>
        </aside>
    </main>

    <footer class="flex flex-col w-full max-w-[1312px] mx-auto rounded-[32px] bg-black p-[120px] mt-[120px] mb-16">
        <div class="flex justify-between">
            <div class="flex flex-col gap-6 max-w-[306px] text-start">
                <img src="{{asset('assets/images/logos/Logo-2.svg')}}" class="h-12 w-fit" alt="icon">
                <p class="tracking-03 text-white">Largest gym in Indonesia, top-tier facilities, premium amenities, and nationwide access to all gym location</p>
            </div>
            <nav class="flex gap-16 justify-end text-white">
                <ul class="flex flex-col gap-4">
                    <p class="font-semibold tracking-03">More to Know</p>
                    <li>
                        <a href="#" class="tracking-03">Blog</a>
                    </li>
                    <li>
                        <a href="#" class="tracking-03">Subscription</a>
                    </li>
                    <li>
                        <a href="#" class="tracking-03">Testimonial</a>
                    </li>
                    <li>
                        <a href="#" class="tracking-03">About</a>
                    </li>
                </ul>
                <ul class="flex flex-col gap-4">
                    <p class="font-semibold tracking-03">Contact Us</p>
                    <li>
                        <a href="#" class="tracking-03">021 543 545 676</a>
                    </li>
                    <li>
                        <a href="#" class="tracking-03">@fitcamp.bodyfit</a>
                    </li>
                    <li>
                        <a href="#" class="tracking-03">admin@fitcamp.com</a>
                    </li>
                </ul>
            </nav>
        </div>
        <hr class="border-white/50 mt-16">
        <div class="flex items-center justify-between mt-[30px]">
            <p class="font-semibold tracking-03 text-white">© 2024 fitcampcorporation</p>
            <ul class="flex items-center justify-end gap-6 text-white">
                <li>
                    <a href="#" class="tracking-03">Term of Services</a>
                </li>
                <li>
                    <a href="#" class="tracking-03">Privacy Policy</a>
                </li>
                <li>
                    <a href="#" class="tracking-03">Cookies</a>
                </li>
                <li>
                    <a href="#" class="tracking-03">Legal</a>
                </li>
            </ul>
        </div>
    </footer>

    <script src="js/details.js"></script>
@endsection

@push('after-scripts')
<script src="{{asset('js/details.js')}}"></script>
@endpush