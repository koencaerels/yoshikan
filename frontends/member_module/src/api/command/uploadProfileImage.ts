import axios from "axios";

export interface UploadProfileImageCommand {
    id: number;
    imageBlob: string;
}

export async function uploadProfileImage(command: UploadProfileImageCommand) {
    const formData = new FormData();
    formData.append('profileImage', command.imageBlob,'profile.png');
    const response = await axios.post<boolean>(`member/${command.id}/profile-image-upload`, formData);
    return response.data;
}
