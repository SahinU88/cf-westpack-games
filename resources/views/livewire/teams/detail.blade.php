<section class="w-full">
    @include('partials.teams-heading')

    <x-teams.layout :heading="$team->name" :subheading="__('The members.')" :teams="$teams">
        <div class="">
            <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($team->users as $user)
                <li class="col-span-1 divide-y divide-gray-200 rounded-lg bg-white shadow-sm">
                    <div class="flex w-full items-center justify-between space-x-6 p-6">
                      <div class="flex-1 truncate">
                        <div class="flex items-center space-x-3">
                          <h3 class="truncate text-sm font-medium text-gray-900">{{ $user->name }}</h3>
                          @if ($user->is_team_captain)
                          <span class="inline-flex shrink-0 items-center rounded-full bg-green-50 px-1.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-green-600/20 ring-inset">Team Captain</span>
                          @endif
                        </div>
                        <p class="mt-1 truncate text-sm text-gray-500 italic">
                            Division: <span class="font-bold">{{ $user->profile->division }}</span>
                        </p>
                      </div>
                    </div>
                  </li>
                @endforeach
            </ul>
        </div>
    </x-teams.layout>
</section>
