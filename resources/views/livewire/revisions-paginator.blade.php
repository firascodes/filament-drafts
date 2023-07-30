<div class="flex flex-col md:flex-row justify-between gap-2  px-4 py-3">
	<div class="w-full flex flex-col">
		<span class="font-medium text-lg">{{ __('filament-drafts::paginator.title') }}</span>
		<div>{{ __('filament-drafts::paginator.counts.overview', [
			    'published' => trans_choice('filament-drafts::paginator.counts.published', $counts['published']),
			    'drafts' => trans_choice('filament-drafts::paginator.counts.drafts', $counts['drafts']),
			    'revisions' => trans_choice('filament-drafts::paginator.counts.revisions', $counts['revisions'], [
                    'max' => config('drafts.revisions.keep'),
]),
			]) }}
	</div>
	<div class="w-full flex items-center justify-end">
		<div class="w-full flex flex-col lg:items-end">
                    @php
                        $isRtl = __('filament-panels::layout.direction') === 'rtl';
                    @endphp

                    <ol
                        class="hidden justify-self-end rounded-lg bg-white shadow-sm ring-1 ring-gray-950/10 dark:bg-white/5 dark:ring-white/20 md:flex"
                    >
                        @isset($previousRevision)
                            <x-filament-drafts::pagination-item
                                :aria-label="__('filament::components/pagination.actions.previous.label')"
                                :icon="$isRtl ? 'heroicon-m-chevron-right' : 'heroicon-m-chevron-left'"
                                icon-alias="pagination.previous-button"
                                rel="prev"
                                href="{{$resource::getUrl('edit', ['record' => $previousRevision])}}"

                            />
                        @endisset

                        @foreach($revisions as $revision)
                            @php
                                if ($revision->isPublished()) {
                                    $label = substr(__('filament-drafts::paginator.published'), 0, 1);
                                } elseif($revision->is_current) {
                                    $label = substr(__('filament-drafts::paginator.draft'), 0, 1);
                                } else {
                                    $label = $loop->iteration;
                                }
                            @endphp

                            <x-filament-drafts::pagination-item
                                :published="$revision->id !== $record->id && $revision->isPublished()"
                                :draft="$revision->id !== $record->id && $revision->is_current"
                                :active="$revision->id === $record->id"
                                :label="$label"
                                href="{{$resource::getUrl('edit', ['record' => $revision])}}"
                            />
                        @endforeach

                        @isset($nextRevision)
                            <x-filament-drafts::pagination-item
                                :aria-label="__('filament::components/pagination.actions.next.label')"
                                :icon="$isRtl ? 'heroicon-m-chevron-left' : 'heroicon-m-chevron-right'"
                                icon-alias="pagination.next-button"
                                rel="next"
                                href="{{$resource::getUrl('edit', ['record' => $nextRevision])}}"
                            />
                        @endisset
                    </ol>

					{{-- <ol class="relative w-full flex items-center text-sm text-gray-500 divide-x rtl:divide-x-reverse divide-gray-300">
						@isset($previousRevision)
							<li>
								<a
										href="{{$resource::getUrl('edit', ['record' => $previousRevision])}}"
										@class([
											'filament-tables-pagination-item relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none hover:bg-gray-500/5 focus:bg-primary-500/10 focus:ring-2 focus:ring-primary-500 transition text-primary-600',
										])
								>
									<
								</a>
							</li>
						@endisset

						@foreach($revisions as $revision)
							<li>
								<a
										href="{{$resource::getUrl('edit', ['record' => $revision])}}"
										@class([
											'filament-tables-pagination-item relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none hover:bg-gray-500/5 focus:bg-primary-500/10 focus:ring-2 focus:ring-primary-500 focus:text-primary-600 transition',
											'bg-success-500/10 ring-success-500 ring-2 outline-none text-success-600' => $revision->id !== $record->id && $revision->isPublished(),
											'bg-gray-500/10 ring-gray-300 ring-2 outline-none text-gray-400' => $revision->id !== $record->id && $revision->is_current,
											'bg-primary-500/10 ring-primary-500 ring-2 outline-none text-primary-600' => $revision->id === $record->id,
										])
								>
									@if($revision->isPublished())
										{{ substr(__('filament-drafts::paginator.published'), 0, 1) }}
									@elseif($revision->is_current)

										{{ substr(__('filament-drafts::paginator.draft'), 0, 1) }}
									@else
										{{ $loop->iteration }}
									@endif
								</a>
							</li>
						@endforeach

						@isset($nextRevision)
							<li>
								<a
										href="{{$resource::getUrl('edit', ['record' => $nextRevision])}}"
										@class([
											'filament-tables-pagination-item relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none hover:bg-gray-500/5 focus:bg-primary-500/10 focus:ring-2 focus:ring-primary-500 transition text-primary-600',
										])
								>
									>
								</a>
							</li>
						@endisset
					</ol> --}}
			<div class="ml-auto mr-0 py-3 pt-5">
				<div class="flex items-end flex-row gap-2">
					<div @class([
				    "filament-tables-pagination-item relative flex items-center justify-center min-w-[2rem] px-1.5 text-sm h-4 -my-3 rounded-md outline-none hover:bg-gray-500/5 focus:bg-primary-500/10 focus:ring-2 focus:ring-primary-500 focus:text-primary-600 transition",
				    "bg-success-500/10 ring-success-500 ring-1 outline-none text-success-600"
				])>
						<span class="first-letter:font-extrabold">{{ __('filament-drafts::paginator.published') }}</span>
					</div>
					<div @class([
				    "filament-tables-pagination-item relative flex items-center justify-center min-w-[2rem] px-1.5 text-sm h-4 -my-3 rounded-md outline-none hover:bg-gray-500/5 focus:bg-primary-500/10 focus:ring-2 focus:ring-primary-500 focus:text-primary-600 transition",
				    "bg-gray-500/10 ring-gray-300 ring-1 outline-none text-gray-400"
				])>
						<span class="first-letter:font-extrabold">{{ __('filament-drafts::paginator.draft') }}</span>
					</div>
					<div @class([
				    "filament-tables-pagination-item relative flex items-center justify-center min-w-[2rem] px-1.5 text-sm h-4 -my-3 rounded-md outline-none hover:bg-gray-500/5 focus:bg-primary-500/10 focus:ring-2 focus:ring-primary-500 focus:text-primary-600 transition",
				    "bg-primary-500/10 ring-primary-500 ring-1 outline-none text-primary-600"
				])>

						<span class="first-letter:font-extrabold">{{ __('filament-drafts::paginator.current') }}</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
