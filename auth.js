/**
 * Auth Utility for Database-less Authentication
 * Uses localStorage to persist user data and sessions
 */

const AUTH_CONFIG = {
    USER_KEY: 'app_users',
    SESSION_KEY: 'app_session'
};

const Auth = {
    // Get all registered users
    getUsers: function() {
        const users = localStorage.getItem(AUTH_CONFIG.USER_KEY);
        return users ? JSON.parse(users) : [];
    },

    // Register a new user
    signup: function(username, email, password) {
        const users = this.getUsers();
        
        // Check if username already exists
        if (users.find(u => u.username === username)) {
            return { success: false, message: 'Username sudah digunakan!' };
        }

        const newUser = {
            id: Date.now(),
            username: username,
            email: email,
            password: password // In a real app, this should be hashed, but for demo we store as is
        };

        users.push(newUser);
        localStorage.setItem(AUTH_CONFIG.USER_KEY, JSON.stringify(users));
        return { success: true, message: 'Pendaftaran berhasil!' };
    },

    // Login user
    login: function(username, password) {
        const users = this.getUsers();
        const user = users.find(u => u.username === username && u.password === password);

        if (user) {
            const sessionData = {
                id: user.id,
                username: user.username,
                email: user.email,
                loginTime: new Date().toISOString()
            };
            localStorage.setItem(AUTH_CONFIG.SESSION_KEY, JSON.stringify(sessionData));
            return { success: true };
        }

        return { success: false, message: 'Username atau password salah!' };
    },

    // Logout
    logout: function() {
        localStorage.removeItem(AUTH_CONFIG.SESSION_KEY);
        window.location.href = 'login.html';
    },

    // Check if user is logged in
    getSession: function() {
        const session = localStorage.getItem(AUTH_CONFIG.SESSION_KEY);
        return session ? JSON.parse(session) : null;
    },

    // Guard for protected pages
    guard: function() {
        if (!this.getSession()) {
            window.location.href = 'login.html';
        }
    }
};
