<div>
  <ul role="list" class="grid gap-x-8 gap-y-12 sm:grid-cols-2 sm:gap-y-16 xl:col-span-2">
      <li>
          <div class="flex items-center gap-x-6">
              <img class="w-16 h-16 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
              <div>
                  <h3 class="text-base font-semibold leading-7 tracking-tight text-gray-900 dark:text-gray-100">
                      {{ $titel }} {{ $vorname }} {{ $nachname }}
                  </h3>
                  <p class="text-sm font-semibold leading-6 text-gray-600 dark:text-gray-300">{{ $position }}</p>
                  <p class="text-sm font-semibold leading-6 text-gray-600 dark:text-gray-300">{{ $email }}</p>
                  <p class="text-sm font-semibold leading-6 text-gray-600 dark:text-gray-300">{{ $tel }}</p>
                  <p class="text-sm font-semibold leading-6 text-gray-600 dark:text-gray-300">{{ $mobil }}</p>
                  <p class="text-sm font-semibold leading-6 text-gray-600 dark:text-gray-300">
                      {{ $deleted === 'Ja' ? 'Gelöscht' : 'Aktiv' }}
                  </p>
              </div>
          </div>
      </li>
  </ul>
</div>
