import axios from 'axios';

const userPreferencesService = {
    async getPreferences() {
        try {
            const response = await axios.get('/user/preferences');
            return response.data;
        } catch (error) {
            console.error('Error fetching user preferences:', error);
            throw error;
        }
    },
    async updatePreferences(preferences) {
        try {
            const response = await axios.post('/user/preferences', preferences);
            return response.data;
        } catch (error) {
            console.error('Error updating user preferences:', error);
            throw error;
        }
    }
};

export default userPreferencesService;
