const EMOJIS = ['👍', '😄', '🎉', '❤️', '🚀', '👀'];
const STORAGE_KEY = 'commenter';

function getAuth() {
    try {
        return JSON.parse(localStorage.getItem(STORAGE_KEY));
    } catch {
        return null;
    }
}

function clearAuth() {
    localStorage.removeItem(STORAGE_KEY);
}

function setAuth(data) {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
}

async function api(path, options = {}) {
    const auth = getAuth();
    const headers = {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        ...options.headers,
    };

    if (auth?.token) {
        headers['Authorization'] = `Bearer ${auth.token}`;
    }

    const response = await fetch(path, { ...options, headers });

    if (response.status === 401) {
        clearAuth();
        return null;
    }

    return response;
}

function timeAgo(dateString) {
    const seconds = Math.floor((Date.now() - new Date(dateString)) / 1000);
    const intervals = [
        [31536000, 'year'], [2592000, 'month'], [86400, 'day'],
        [3600, 'hour'], [60, 'minute'],
    ];

    for (const [secs, label] of intervals) {
        const count = Math.floor(seconds / secs);
        if (count >= 1) {
            return `${count} ${label}${count > 1 ? 's' : ''} ago`;
        }
    }

    return 'just now';
}

function h(tag, attrs = {}, children = []) {
    const el = document.createElement(tag);

    for (const [key, value] of Object.entries(attrs)) {
        if (key === 'className') {
            el.className = value;
        } else if (key.startsWith('on')) {
            el.addEventListener(key.slice(2).toLowerCase(), value);
        } else {
            el.setAttribute(key, value);
        }
    }

    for (const child of Array.isArray(children) ? children : [children]) {
        if (typeof child === 'string') {
            el.appendChild(document.createTextNode(child));
        } else if (child) {
            el.appendChild(child);
        }
    }

    return el;
}

function reactionBtnClass(isActive) {
    if (isActive) {
        return 'inline-flex items-center gap-0.5 px-1.5 py-0.5 rounded-full text-xs border border-blue-300 bg-blue-50 text-blue-700 cursor-pointer transition-colors';
    }
    return 'inline-flex items-center gap-0.5 px-1.5 py-0.5 rounded-full text-xs border border-gray-200 bg-white text-gray-600 hover:border-gray-300 hover:bg-gray-50 cursor-pointer transition-colors';
}

// Full reaction bar — shows all 8 emojis (used for post-level reactions)
function renderPostReactionBar(reactions, onToggle, auth, onSignIn) {
    const bar = h('div', { className: 'flex flex-wrap gap-1 items-center' });

    for (const emoji of EMOJIS) {
        const data = reactions[emoji];
        const count = data?.count || 0;
        const isActive = auth && data?.commenter_ids?.includes(auth.commenter.id);

        const btn = h('button', {
            className: reactionBtnClass(isActive),
            onClick: () => auth ? onToggle(emoji) : onSignIn(),
        }, [
            h('span', { className: 'leading-none' }, emoji),
            ...(count > 0 ? [h('span', {}, String(count))] : []),
        ]);

        bar.appendChild(btn);
    }

    return bar;
}

// Compact reaction bar — only shows emojis with counts + a "+" picker (used for comments)
function renderCommentReactionBar(reactions, onToggle, auth, onSignIn) {
    const bar = h('div', { className: 'flex flex-wrap gap-1 items-center' });

    for (const emoji of EMOJIS) {
        const data = reactions[emoji];
        const count = data?.count || 0;
        if (count === 0 && !(auth && data?.commenter_ids?.includes(auth?.commenter?.id))) continue;

        const isActive = auth && data?.commenter_ids?.includes(auth.commenter.id);

        bar.appendChild(h('button', {
            className: reactionBtnClass(isActive),
            onClick: () => auth ? onToggle(emoji) : onSignIn(),
        }, [
            h('span', { className: 'leading-none' }, emoji),
            h('span', {}, String(count)),
        ]));
    }

    // Add reaction "+" button with picker
    const wrapper = h('div', { className: 'relative inline-block' });

    const addBtn = h('button', {
        className: 'inline-flex items-center justify-center w-6 h-6 rounded-full text-xs border border-gray-200 bg-white text-gray-400 hover:border-gray-300 hover:text-gray-600 cursor-pointer transition-colors',
        onClick: (event) => {
            event.stopPropagation();
            if (!auth) { onSignIn(); return; }
            const pickerEl = wrapper.querySelector('[data-picker]');
            const isOpen = !pickerEl.classList.contains('hidden');
            document.querySelectorAll('[data-picker]').forEach(p => p.classList.add('hidden'));
            if (!isOpen) {
                pickerEl.classList.remove('hidden');
            }
        },
    }, '+');

    const picker = h('div', {
        className: 'hidden absolute bottom-full left-0 mb-1 flex gap-0.5 bg-white border border-gray-200 rounded-lg shadow-sm p-1 z-10',
    });
    picker.setAttribute('data-picker', '');

    for (const emoji of EMOJIS) {
        picker.appendChild(h('button', {
            className: 'hover:bg-gray-100 rounded px-1 py-0.5 text-sm cursor-pointer transition-colors',
            onClick: () => {
                onToggle(emoji);
                picker.classList.add('hidden');
            },
        }, emoji));
    }

    wrapper.append(addBtn, picker);
    bar.appendChild(wrapper);

    return bar;
}

function renderComment(comment, auth, onDelete, onReactionToggle, onSignIn) {
    const canDelete = auth && (auth.commenter.id === comment.commenter.id || auth.commenter.is_admin);

    const header = h('div', { className: 'flex items-center gap-2' }, [
        h('img', {
            src: comment.commenter.avatar_url,
            alt: comment.commenter.name,
            className: 'w-7 h-7 rounded-full',
        }),
        h('a', {
            href: `https://github.com/${comment.commenter.username}`,
            className: 'font-semibold text-sm text-gray-800 hover:underline',
            target: '_blank',
            rel: 'noopener noreferrer',
        }, comment.commenter.name),
        h('span', { className: 'text-xs text-gray-400' }, timeAgo(comment.created_at)),
    ]);

    if (canDelete) {
        header.appendChild(h('button', {
            className: 'ml-auto text-xs text-gray-400 hover:text-red-500 transition-colors',
            onClick: () => onDelete(comment.id),
        }, 'Delete'));
    }

    const body = h('div', { className: 'markup text-sm mt-1' });
    body.innerHTML = comment.body_html;

    const reactionBar = renderCommentReactionBar(
        comment.reactions,
        (emoji) => onReactionToggle(comment.id, emoji),
        auth,
        onSignIn,
    );

    return h('div', { className: 'py-4 border-b border-gray-100 last:border-0' }, [
        header,
        body,
        h('div', { className: 'mt-2' }, [reactionBar]),
    ]);
}

function renderSignIn(onSignIn) {
    return h('p', { className: 'text-sm text-gray-500' }, [
        h('a', {
            href: '#',
            className: 'text-gray-700 underline decoration-gray-300 hover:text-black hover:decoration-black transition-colors cursor-pointer',
            onClick: (e) => { e.preventDefault(); onSignIn(); },
        }, 'Sign in with GitHub'),
        ' to comment and react.',
    ]);
}

function renderCommentForm(auth, onSubmit, onSignOut) {
    const container = h('div', { className: 'mt-4' });

    const userInfo = h('div', { className: 'flex items-center gap-2 mb-3' }, [
        h('img', { src: auth.commenter.avatar_url, className: 'w-5 h-5 rounded-full' }),
        h('span', { className: 'text-sm text-gray-600' }, `Commenting as ${auth.commenter.name}`),
        h('button', {
            className: 'text-xs text-gray-400 hover:text-gray-600 ml-auto',
            onClick: onSignOut,
        }, 'Sign out'),
    ]);

    const textarea = h('textarea', {
        className: 'w-full border border-gray-200 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-300 resize-y min-h-24',
        placeholder: 'Write a comment... (Markdown supported)',
    });

    const submitBtn = h('button', {
        className: 'mt-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50',
        onClick: async () => {
            const body = textarea.value.trim();
            if (!body) return;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Posting...';
            const success = await onSubmit(body);
            submitBtn.disabled = false;
            submitBtn.textContent = 'Post comment';
            if (success) textarea.value = '';
        },
    }, 'Post comment');

    container.append(userInfo, textarea, submitBtn);
    return container;
}

function initCommentsWidget(el) {
    const postSlug = el.dataset.postSlug;
    if (!postSlug) return;

    let comments = [];
    let postReactions = {};
    let auth = getAuth();

    function render() {
        el.innerHTML = '';

        const section = h('div', {});

        // Post reactions
        const reactionSection = h('div', { className: 'mb-4' });
        reactionSection.appendChild(renderPostReactionBar(postReactions, togglePostReaction, auth, signIn));
        section.appendChild(reactionSection);

        // Comments header
        const headerText = comments.length === 1 ? '1 comment' : `${comments.length} comments`;
        section.appendChild(h('h4', { className: 'text-sm font-semibold text-gray-700 mb-3' }, headerText));

        // Comment list
        if (comments.length > 0) {
            const list = h('div', { className: 'mb-4' });
            for (const comment of comments) {
                list.appendChild(renderComment(comment, auth, deleteComment, toggleCommentReaction, signIn));
            }
            section.appendChild(list);
        }

        // Auth / Comment form
        if (auth) {
            section.appendChild(renderCommentForm(auth, submitComment, signOut));
        } else {
            section.appendChild(renderSignIn(signIn));
        }

        el.appendChild(section);
    }

    async function fetchComments() {
        const response = await api(`/api/posts/${postSlug}/comments`);
        if (!response?.ok) return;
        const data = await response.json();
        comments = data.comments;
        postReactions = data.post_reactions;
        render();
    }

    async function submitComment(body) {
        const response = await api(`/api/posts/${postSlug}/comments`, {
            method: 'POST',
            body: JSON.stringify({ body }),
        });

        if (!response) {
            render();
            return false;
        }

        if (!response.ok) return false;

        const comment = await response.json();
        comments.push(comment);
        render();
        return true;
    }

    async function deleteComment(commentId) {
        const response = await api(`/api/comments/${commentId}`, { method: 'DELETE' });

        if (!response) {
            render();
            return;
        }

        comments = comments.filter(c => c.id !== commentId);
        render();
    }

    async function togglePostReaction(emoji) {
        const response = await api(`/api/posts/${postSlug}/reactions`, {
            method: 'POST',
            body: JSON.stringify({ emoji }),
        });

        if (!response) {
            render();
            return;
        }

        await fetchComments();
    }

    async function toggleCommentReaction(commentId, emoji) {
        const response = await api(`/api/comments/${commentId}/reactions`, {
            method: 'POST',
            body: JSON.stringify({ emoji }),
        });

        if (!response) {
            render();
            return;
        }

        await fetchComments();
    }

    function signIn() {
        const width = 600;
        const height = 700;
        const left = (screen.width - width) / 2;
        const top = (screen.height - height) / 2;

        const popup = window.open(
            '/auth/github',
            'github-auth',
            `width=${width},height=${height},left=${left},top=${top}`
        );

        window.addEventListener('message', function handler(event) {
            if (event.origin !== window.location.origin) return;
            if (event.data?.type !== 'github-auth') return;

            window.removeEventListener('message', handler);

            setAuth({
                token: event.data.token,
                commenter: event.data.commenter,
            });

            auth = getAuth();
            render();
        });
    }

    function signOut() {
        clearAuth();
        auth = null;
        render();
    }

    // Lazy load with IntersectionObserver
    const observer = new IntersectionObserver((entries) => {
        if (entries[0].isIntersecting) {
            observer.disconnect();
            fetchComments();
        }
    }, { rootMargin: '500px' });

    observer.observe(el);

    document.addEventListener('click', () => {
        el.querySelectorAll('[data-picker]').forEach(p => p.classList.add('hidden'));
    });
}

document.querySelectorAll('[data-comments-widget]').forEach(initCommentsWidget);
