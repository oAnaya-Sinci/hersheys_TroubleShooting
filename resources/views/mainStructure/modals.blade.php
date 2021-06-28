<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modal-hersheys">
                <h5 class="modal-title" id="ModalLabel">¿Listo para irte?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Selecione "Salir" para cerrar su sesion.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a id="logoutBtn" class="btn btn-primary" href="#">Salir</a>
            </div>
        </div>
    </div>
</div>

<!-- Succes Modal-->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header modal-hersheys">
                <h5 class="modal-title" id="exampleModalLabel">Exito</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Registro realizado exitosamente</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal-->
<div class="modal fade" id="MessageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header modal-hersheys">
                <h5 class="modal-title" id="exampleModalLabel">Mensaje del sistema</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal-->
<div class="modal fade errorModal" id="ErrorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header modal-Error">
                <h5 class="modal-title" id="exampleModalLabel">Mensaje del sistema</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal-->
<div class="modal fade" id="ModificarUsuariosModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modal-hersheys">
                <h5 class="modal-title" id="exampleModalLabel">Modificar usuario: <span class="nameUser"></span> </h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="userId">

                <label class="mb-0">Nombre:</label>
                <input type="text" class="form-control mt-0" id="nombreEdit" />

                <!-- <label class="mb-0 mt-3">Email:</label>
                <input type="text" class="form-control mt-0" id="emailEdit" /> -->

                <label class="mb-0 mt-3">Admin User:</label>
                <select id="adminUserEdit" class="form-control">
                    <option value="True">True</option>
                    <option value="False">False</option>
                </select>

                <label class="mb-0 mt-3">Ver Reportes:</label>
                <select id="seeReportEdit" class="form-control">
                    <option value="True">True</option>
                    <option value="False">False</option>
                </select>

                <label class="mb-0 mt-3">Nueva Contraseña:</label>
                <input type="text" class="form-control mt-0" id="newPassword" />
            </div>
            <div class="modal-footer">
                <button id="updateInfoUser" class="btn btn-success" type="button" data-dismiss="modal">Guardar</button>
                <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Borrar usuarios Modal-->
<div class="modal fade errorModal" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header modal-Error">
                <h5 class="modal-title" id="exampleModalLabel">¡Atencion!</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="userId">
                <p> La información al ser borrada se perdara y no podra ser recuperada en el futuro</p>
                <p>¿Desea continuar con la eliminacion de la información?</p>
            </div>
            <div class="modal-footer">
                <button id="deleteDataUser" class="btn btn-danger" type="button" data-dismiss="modal">Continuar</button>
                <button class="btn btn-success" type="button" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Borrar usuarios Modal-->
<div class="modal fade errorModal" id="deleteCatalogModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header modal-Error">
                <h5 class="modal-title" id="exampleModalLabel">¡Atencion!</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="catalogId">
                <p> La información al ser borrada se perdara y no podra ser recuperada en el futuro</p>
                <p>¿Desea continuar con la eliminacion de la información?</p>
            </div>
            <div class="modal-footer">
                <button id="delteDataCatalogo" class="btn btn-danger" type="button" data-dismiss="modal">Continuar</button>
                <button class="btn btn-success" type="button" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
