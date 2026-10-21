<aside class="candidate-sidebar" data-sidebar>
    <div class="sidebar-brand">hirebridge</div>

    <div class="sidebar-scroll">
        <p class="sidebar-eyebrow">Candidate</p>

        <button class="sidebar-workspace" type="button">
            Personal workspace <span aria-hidden="true">⌄</span>
        </button>

        <nav class="sidebar-nav" aria-label="Candidate navigation">
            <a href="#overview">Overview</a>
            <a href="{{ route('jobs.index') }}">Discover jobs</a>
            <a href="#saved-jobs">Saved jobs</a>
            <a href="{{ route('candidate.applications.offer.show') }}" @class(['active' => request()->routeIs('candidate.applications.*')])>
                @if (request()->routeIs('candidate.applications.*'))
                    <span class="sidebar-active-dot"></span>
                @endif
                My applications
            </a>
            <a href="#interviews">Interviews</a>
            <a href="#messages">Messages</a>
            <a href="{{ route('candidate.profile.show') }}" @class(['active' => request()->routeIs('candidate.profile.*')])>
                @if (request()->routeIs('candidate.profile.*'))
                    <span class="sidebar-active-dot"></span>
                @endif
                Profile &amp; resume
            </a>
            <a href="{{ route('candidate.preferences.show') }}" @class(['active' => request()->routeIs('candidate.preferences.*')])>
                @if (request()->routeIs('candidate.preferences.*'))
                    <span class="sidebar-active-dot"></span>
                @endif
                Preferences &amp; alerts
            </a>
        </nav>

        <nav class="sidebar-nav sidebar-nav-bottom" aria-label="Support navigation">
            <a href="#support">Help &amp; support</a>
            <a href="#privacy">Privacy &amp; security</a>
        </nav>
    </div>
</aside>
