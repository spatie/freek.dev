const EMOJIS = ['👍', '👎', '😄', '🎉', '😕', '❤️', '🚀', '👀'];
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

function renderReactionBar(reactions, onToggle, auth, onSignIn) {
    const bar = h('div', { className: 'flex flex-wrap gap-1.5 items-center' });

    for (const emoji of EMOJIS) {
        const data = reactions[emoji];
        const count = data?.count || 0;
        const isActive = auth && data?.commenter_ids?.includes(auth.commenter.id);

        const btn = h('button', {
            className: `inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-sm border transition-colors ${
                isActive
                    ? 'border-blue-300 bg-blue-50 text-blue-700'
                    : 'border-gray-200 bg-white text-gray-600 hover:border-gray-300 hover:bg-gray-50'
            } cursor-pointer`,
            onClick: () => auth ? onToggle(emoji) : onSignIn(),
        }, [
            h('span', {}, emoji),
            ...(count > 0 ? [h('span', { className: 'text-xs' }, String(count))] : []),
        ]);

        bar.appendChild(btn);
    }

    return bar;
}

function renderComment(comment, auth, onDelete, onReactionToggle, onSignIn) {
    const canDelete = auth && (auth.commenter.id === comment.commenter.id || auth.commenter.is_admin);

    const header = h('div', { className: 'flex items-center gap-2' }, [
        h('img', {
            src: comment.commenter.avatar_url,
            alt: comment.commenter.name,
            className: 'w-8 h-8 rounded-full',
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

    const reactionBar = renderReactionBar(comment.reactions, (emoji) => onReactionToggle(comment.id, emoji), auth, onSignIn);

    return h('div', { className: 'py-4 border-b border-gray-100 last:border-0' }, [
        header,
        body,
        h('div', { className: 'mt-2' }, [reactionBar]),
    ]);
}

function renderSignIn(onSignIn) {
    return h('button', {
        className: 'inline-flex items-center gap-2 px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors',
        onClick: onSignIn,
    }, [
        h('svg', { className: 'w-4 h-4', viewBox: '0 0 16 16', fill: 'currentColor' }, [
            h('path', { d: 'M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0016 8c0-4.42-3.58-8-8-8z' }),
        ]),
        'Sign in with GitHub to comment and react',
    ]);
}

function renderCommentForm(auth, onSubmit, onSignOut) {
    const container = h('div', { className: 'mt-4' });

    const userInfo = h('div', { className: 'flex items-center gap-2 mb-3' }, [
        h('img', { src: auth.commenter.avatar_url, className: 'w-6 h-6 rounded-full' }),
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
        const reactionSection = h('div', { className: 'mb-6' });
        reactionSection.appendChild(renderReactionBar(postReactions, togglePostReaction, auth, signIn));
        section.appendChild(reactionSection);

        // Comments header
        const headerText = comments.length === 1 ? '1 comment' : `${comments.length} comments`;
        section.appendChild(h('h3', { className: 'text-lg font-semibold mb-2' }, headerText));

        // Comment list
        const list = h('div', { className: 'mb-4' });
        for (const comment of comments) {
            list.appendChild(renderComment(comment, auth, deleteComment, toggleCommentReaction, signIn));
        }
        section.appendChild(list);

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
}

document.querySelectorAll('[data-comments-widget]').forEach(initCommentsWidget);
