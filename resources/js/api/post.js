import axios from "axios";

function getSchoolPost(payload) {
  return axios.get("/api/v1/schoolPost", { params: payload });
}

function getClassPost(classId, page) {
  return axios.get("/api/v1/classPost", {
    params: { classId: classId, page: page }
  });
}

function addLike(payload) {
  return axios.post("/api/v1/like", payload);
}

function removeLike(payload) {
  return axios.delete("/api/v1/like", { data: payload });
}
function addViewUsers(payload) {
  return axios.post("/api/v1/viewUser", payload);
}

function addComment(payload) {
  return axios.post("/api/v1/comment", payload);
}

function deleteComment(payload) {
  return axios.delete("/api/v1/comment", { data: payload });
}

export {
  getSchoolPost,
  getClassPost,
  addLike,
  removeLike,
  addViewUsers,
  addComment,
  deleteComment
};
