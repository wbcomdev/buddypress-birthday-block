// fetchProfileFields.js
import apiFetch from '@wordpress/api-fetch';

// Function to fetch xProfile fields from BuddyPress API
export const fetchProfileFields = async () => {
    try {
        const fields = await apiFetch({ path: 'buddypress/v1/xprofile/fields' });
        // Filter and map the fields to return only the necessary options (e.g., datebox fields)
        return fields
            .filter((field) => field.type === 'datebox') // Filter to include only 'datebox' types
            .map((field) => ({
                value: field.id,
                label: field.name,
            }));
    } catch (err) {
        console.error('Error fetching xProfile fields:', err);
        return []; // Return an empty array in case of error
    }
};
