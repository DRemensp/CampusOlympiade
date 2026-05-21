let subscribedAs = null; // 'guest' | 'admin' | 'teacher' | 'class' | null
let adminBroadcastTimer = null;

function getUserRoles() {
    const roles = document.body?.dataset?.roles || '';
    return roles
        .split(',')
        .map((role) => role.trim())
        .filter((role) => role.length > 0);
}

function showAdminBroadcast(message) {
    const popup = document.getElementById('adminBroadcastPopup');
    if (!popup) return;

    const messageEl = popup.querySelector('[data-admin-broadcast-message]');
    const closeBtn = popup.querySelector('[data-admin-broadcast-close]');
    const timerEl = popup.querySelector('[data-admin-broadcast-timer]');

    if (messageEl) {
        messageEl.textContent = message;
    }

    popup.classList.remove('hidden');

    if (adminBroadcastTimer) {
        clearInterval(adminBroadcastTimer);
        adminBroadcastTimer = null;
    }

    let remaining = 5;

    if (closeBtn) {
        closeBtn.disabled = true;
        closeBtn.classList.add('opacity-50', 'cursor-not-allowed', 'bg-gray-400', 'dark:bg-gray-600');
        closeBtn.classList.remove('bg-blue-600', 'hover:bg-blue-500');
    }

    if (timerEl) {
        timerEl.textContent = `(${remaining}s)`;
    }

    adminBroadcastTimer = setInterval(() => {
        remaining -= 1;

        if (timerEl) {
            timerEl.textContent = remaining > 0 ? `(${remaining}s)` : '';
        }

        if (remaining <= 0) {
            clearInterval(adminBroadcastTimer);
            adminBroadcastTimer = null;

            if (closeBtn) {
                closeBtn.disabled = false;
                closeBtn.classList.remove('opacity-50', 'cursor-not-allowed', 'bg-gray-400', 'dark:bg-gray-600');
                closeBtn.classList.add('bg-blue-600', 'hover:bg-blue-500');
            }
        }
    }, 1000);

    if (closeBtn && !closeBtn.dataset.bound) {
        closeBtn.addEventListener('click', () => {
            popup.classList.add('hidden');
        });
        closeBtn.dataset.bound = '1';
    }
}

const broadcastHandler = (payload) => {
    if (payload?.message) {
        showAdminBroadcast(payload.message);
    }
};

function leaveCurrentChannel() {
    if (!window.Echo || !subscribedAs) return;
    if (subscribedAs === 'guest') window.Echo.leave('admin-message.guests');
    else if (subscribedAs === 'teacher') window.Echo.leave('admin-message.teachers');
    else if (subscribedAs === 'class') window.Echo.leave('admin-message.klasses');
}

function subscribeAdminBroadcasts() {
    if (!window.Echo) return;

    const isAuthed = document.body?.dataset?.auth === '1';
    const roles = getUserRoles();

    let shouldSubscribeAs;
    if (!isAuthed) shouldSubscribeAs = 'guest';
    else if (roles.includes('admin')) shouldSubscribeAs = 'admin';
    else if (roles.includes('teacher')) shouldSubscribeAs = 'teacher';
    else shouldSubscribeAs = 'class';

    // Kein Wechsel nötig
    if (subscribedAs === shouldSubscribeAs) return;

    // Alten Kanal verlassen
    leaveCurrentChannel();
    subscribedAs = shouldSubscribeAs;

    if (shouldSubscribeAs === 'guest') {
        console.log('Broadcast: Listening as Guest');
        window.Echo.channel('admin-message.guests')
            .listen('.admin.message', broadcastHandler);
    } else if (shouldSubscribeAs === 'admin') {
        console.log('Broadcast: Admin mode - No listening');
        // Admin sendet nur, hört nicht zu
    } else if (shouldSubscribeAs === 'teacher') {
        console.log('Broadcast: Listening as Teacher');
        window.Echo.private('admin-message.teachers')
            .listen('.admin.message', broadcastHandler);
    } else {
        console.log('Broadcast: Listening as Class/Student');
        window.Echo.private('admin-message.klasses')
            .listen('.admin.message', broadcastHandler);
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', subscribeAdminBroadcasts);
} else {
    subscribeAdminBroadcasts();
}

document.addEventListener('livewire:navigated', subscribeAdminBroadcasts);
